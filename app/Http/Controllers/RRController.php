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

class RRController extends Controller
{
    private $tbody_content;

    public function __construct()
    {
        session()->reflash();
    }

    public function index(Request $request){
        // var_dump(session('pin'));
        // var_dump($request->session()->all());
        // die();
        // if(!session('pin')){
        //     $request->session()->flash('initial_message', 'Enter PIN first');
        //     $referrer = urlencode(url()->full());
        //     return redirect(action([PINController::class, 'setPinFlashCashier']) . '?referrer=' . $referrer);
        // }

        // session()->reflash(); 
        $data['heading'] = 'Return/Refund';
        $data['title'] = 'Return/Refund';        
        $data['form'] = 'rr';
        $this->setLastTableContent($request, $data['form']);

        $data['tbody_content'] = $this->tbody_content;
        $data['d_none'] = !empty($data['tbody_content']) ? 'd-none' : '';

        return view('pages.cashier.rr', $data);
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
                $this->tbody_content .= (string) view("components.rr-row", $data);
            }
        }
    }

    public function store(RRRequest $request){       
        $validated = $request->validated();
        
        $this->setRefundDetails($validated);        

        session()->forget([
            'name',
            'item_code',
        ]);
        $request->session()->flash('msg_success', "Product {$validated['type']} successful!");
        return redirect(action([POSController::class, 'index']));
    }

    private function setRefundDetails($validated){        
        $refunded_qty = 0;

        foreach($validated['product_id'] as $key => $product_id){
            // get same products to iterate from a finished transaction
            $products = POSTransaction2ProductModel::where('product_id', $product_id)
                ->where('pos_transaction_id', $validated['transaction_id'])
                ->get();
                $refund_quantity = $validated['quantity'][$key];
            foreach($products as $product){ 
                $a_product = new POSTransaction2ProductModel();                
                $refunded_qty = $a_product->refundPosTransaction2Product($product, $refund_quantity);
                
                if($validated['type'] == 'return'){                        
                    $previous_quantity = Inventory::getStock($product_id);
                    $inventory = new Inventory();
                    // DB::enableQueryLog();
                    $inventory->returnStock($product->product_id, $refunded_qty);                    
                    // dd(DB::getQueryLog());                    

                    $Inventory = Inventory::where('product_id', $product_id);
                    $inventory_id = $Inventory->first()->id;
                                        
                    $updated_quantity = Inventory::find($inventory_id)->stock;

                    // Log
                    InventoryLog::log(
                        $inventory_id,
                        $previous_quantity,
                        $updated_quantity,
                        8 // 8 for add stock
                    );
                }                
                $refund_quantity -= $refunded_qty;
            }   
        }
    }    

    
  
    public function inventorySearch(Request $request)
    {
        session()->reflash();
        $product = $this->getProductFromRequest($request);

        $response = [
            'result' => $product,
        ];

        $response = json_encode($response);
        return Response()->json($response);
    }

    public function getTableRow(Request $request)
    {
        session()->reflash();
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
            $tbody_content = (string) view("components.rr-row", $data);
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
            ->join('product_category as c', 'c.id', '=', 'p.category_id');

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
