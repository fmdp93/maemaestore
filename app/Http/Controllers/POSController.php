<?php

namespace App\Http\Controllers;

use PDF as PDF2;
use Dompdf\Dompdf;
// use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Inventory;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use App\Http\Requests\RRRequest;
use Illuminate\Support\Facades\DB;
use App\Models\POSTransactionModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use \Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Requests\POSCheckoutRequest;
use App\Models\POSTransaction2ProductModel;

class POSController extends Controller
{
    private $tbody_content;
    public function index(Request $request)
    {
        $data['heading'] = 'Point Of Sale';
        $data['title'] = 'POS';
        $data['form'] = 'pos';

        $this->setLastTableContent($request, $data['form']);

        $data['tbody_content'] = $this->tbody_content;
        $data['d_none'] = !empty($data['tbody_content']) ? 'd-none' : '';
        
        return view('pages.cashier.pos', $data);
    }

    private function setLastTableContent($request, $form)
    {
        if (!empty($request->old('product_id'))) {
            foreach ($request->old('product_id') as $key => $product_id) {
                $data['p_id'] = $request->old('product_id')[$key];
                $data['code'] = $request->old('t_item_code')[$key];
                $data['name'] = $request->old('t_name')[$key];
                $data['description'] = $request->old('t_description')[$key];
                $data['quantity'] = $request->old('quantity')[$key];
                $data['price'] = $request->old('price')[$key];
                $data['subtotal'] = $data['price'] * $data['quantity'];
                $data['form'] = $form;
                $this->tbody_content .= (string) view("components.pos-row", $data);
            }
        }
    }

    public function checkout(POSCheckoutRequest $request)
    {
        $validated = $request->validated();

        // make transaction id
        $POSTransaction = new POSTransactionModel();
        $POSTransaction->amount_paid = $request->input('amount_paid');
        $POSTransaction->created_at = date("Y-m-d h:i");
        $POSTransaction->status_id = 4; // Completed
        $POSTransaction->save();

        // insert products
        foreach ($validated['product_id'] as $key => $product_id) {
            $POSTransaction2Product = new POSTransaction2ProductModel();
            $POSTransaction2Product->pos_transaction_id = $POSTransaction->id;
            $POSTransaction2Product->product_id = $product_id;
            $POSTransaction2Product->quantity = $validated['quantity'][$key];
            $POSTransaction2Product->price = $validated['price'][$key];
            $POSTransaction2Product->save();

            $previous_quantity = Inventory::getStock($product_id);

            // reduce stocks in inventory
            $Inventory = Inventory::where('product_id', $product_id);
            $inventory_id = $Inventory->first()->id;

            $Inventory->update([
                'stock' => DB::raw('stock - ' . $validated['quantity'][$key])
            ]);

            $updated_quantity = Inventory::find($inventory_id)->stock;

            // Log
            InventoryLog::log(
                $inventory_id,
                $previous_quantity,
                $updated_quantity,
                9 // 9 = stock deducted
            );
        }

        return redirect(action([POSController::class, 'finish'], ['transacion_id' => $POSTransaction->id]));
    }

    public function finish(Request $request)
    {
        $data['title'] = 'Transaction Completed';
        $data['heading'] = 'Transaction Completed';
        $data['transaction_id'] = $request->input('transacion_id');
        return view('pages.cashier.pos-finish', $data);
    }

    public function receipt(Request $request)
    {
        $data['transaction_id'] = $request->input('transaction_id');
        $data['title'] = 'Maemae\'s Store';
        $data['heading'] = 'Transaction Completed';
        $data['cashier_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $data['items'] = POSTransactionModel::select(DB::raw('pt.created_at, pt.amount_paid,
            pt2p.id pt2p_id, pt2p.quantity, pt2p.price,
            p.name p_name'))
            ->from('pos_transaction as pt')
            ->join('pos_transaction2product as pt2p', 'pt2p.pos_transaction_id', '=', 'pt.id')
            ->join('product as p', 'p.id', '=', 'pt2p.product_id')
            ->where('pt2p.pos_transaction_id', $data['transaction_id'])
            ->get();

        $view = (string) view('pages.cashier.pos-receipt', $data);
        // return $view;
        $base_receipt_height = 264;
        $row_height = 16;
        $paper_height = $base_receipt_height + $row_height * count($data['items']);
        $customPaper = array(0, 0, 264, $paper_height);

        $options = new Options();
        $dompdf = new Dompdf();
        $publicPath = base_path('public/');
        $current_options = $dompdf->getOptions();
        $options->set('chroot', $publicPath);
        $options->set('fontDir', $publicPath);

        $dompdf->setPaper($customPaper);
        $dompdf->setOptions($options);
        $dompdf->setBasePath(base_path('public/'));

        $dompdf->loadHTML($view);
        $dompdf->render();
        $dompdf->stream($request->input('transaction_id'));
    }

    public function inventorySearch(Request $request)
    {
        $product = $this->getProductFromRequest($request);

        $response = [
            'result' => $product,
        ];

        $response = json_encode($response);
        return Response()->json($response);
    }

    public function getTableRow(Request $request)
    {
        $tbody_content = '';
        $product = $this->getProductFromRequest($request);

        if (!empty($product)) {
            $data['p_id'] = $product->p_id;
            $data['code'] = $product->item_code;
            $data['name'] = $product->p_name;
            $data['description'] = $product->description;
            $data['quantity'] = $request->input('quantity');
            $data['price'] = $product->price;
            $data['subtotal'] = $data['price'] * $data['quantity'];
            $data['form'] = $request->input('form');
            $data['xmark_attr'] = 'data-bs-toggle="modal" data-bs-target="#pin-modal"';
            $tbody_content = (string) view("components.pos-row", $data);
        }

        $response = [
            'result' => $product,
            'tbody' => $tbody_content,
            'table_empty' => (string) view('layouts.empty-table'),
        ];

        $response = json_encode($response);
        return Response()->json($response);
    }

    private function getProductFromRequest($request)
    {
        DB::enableQueryLog();
        $markup_price = Config::get('app.markup_price');
        $inventory = Inventory::select(
            DB::raw("i.stock i_stock,
            p.id p_id, p.item_code, p.name p_name,
        p.description, (p.price + p.price * $markup_price) price, p.unit, p.expiration_date, p.stock p_stock,
        c.name c_name")
        )
            ->from('inventory as i')
            ->join('product as p', 'p.id', '=', 'i.product_id')
            ->join('product_category as c', 'c.id', '=', 'p.category_id')
            ->whereNull('i.status_id');

        if ($request->input('item_code')) {
            $inventory = $inventory->where('p.item_code', $request->input('item_code'));
        }

        if ($request->input('item_name')) {
            $inventory = $inventory->where('p.name', 'LIKE', "%" . $request->input('item_name') . "%")
                ->where('p.name', '!=', '');
        }

        if ($request->input('item_name') == "" && $request->input('item_code') == "") {
            $inventory = $inventory->whereRaw('NULL');
        }

        return $inventory->first();
    }
}
