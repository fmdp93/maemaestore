<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use App\Models\InventoryOrder;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryOrder2Product;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePurchaseOrderRequest;

class InventoryController extends Controller
{
    private $tbody_content;

    public function index(Request $request)
    {
        $data['heading'] = 'Inventory';
        $data['categories'] = Category::all();
        $data['search'] = $request->input('q');
        $stock_filter = $request->input('stock_filter');
        $data['category_id'] = $request->input('category_id');
        $Inventory = new Inventory();
        $data['half_stock_products'] = $Inventory->getHalfStock();

        $data['products'] = $Inventory->getProducts($data['search'], $data['category_id'], $stock_filter);
        $data['d_none'] = count($data['products']) ? 'd-none' : '';
        $data['form'] = 'purchase-order';

        return view('pages.admin.inventory', $data);
    }

    public function archive(Request $request){
        $inventory_id = $request->input('inventory_id');
        // sets url params
        $url_params = $request->input('url_params');
        $url_params = $url_params ? "?$url_params" : "";

        Inventory::where('id', $inventory_id)
            ->update(['status_id' => 16]); // 16 is archived
        $request->session()->flash('msg_success', 'Product archived succesfully!');
        $back = action([InventoryController::class, 'index']) . $url_params;
        return redirect($back);
    }

    public function orders(Request $request)
    {
        $data['heading'] = 'Inventory Orders';
        $InventoryOrder = new InventoryOrder();
        $data['inventory_orders'] = $InventoryOrder->getProcessing();

        return view('pages.admin.inventory-orders', $data);
    }

    public function orderProducts(Request $request)
    {
        $io_id = $request->input('io_id');
        $InventoryOrder2Product = new InventoryOrder2Product();
        $data['io_products'] = $InventoryOrder2Product->getProcessingProducts($io_id);
        $response['modal_content'] = (string) view('components.io2p-rows', $data);

        $response = json_encode($response);
        return Response()->json($response);
    }

    public function purchaseOrder(Request $request)
    {
        $data['heading'] = 'Purchase Order Form';

        $this->setHalfStockTbodyContent($request);

        $this->setLastTableContent($request);

        $data['tbody_content'] = $this->tbody_content;
        $data['d_none'] = !empty($data['tbody_content']) ? 'd-none' : '';

        return view('pages.admin.purchase-order', $data);
    }

    private function setHalfStockTbodyContent($request)
    {
        if ($request->input('request_half_stock') == 1 && empty(old())) {
            $Inventory = new Inventory();
            $products = $Inventory->getHalfStock();

            if (!empty($products)) {
                foreach ($products as $product) {
                    $data['form'] = 'purchase-order';
                    $data['p_id'] = $product->p_id;
                    $data['code'] = $product->item_code;
                    $data['name'] = $product->p_name;
                    $data['description'] = $product->description;
                    $data['quantity'] = $product->p_stock - $product->i_stock;
                    $data['price'] = $product->price;
                    $data['subtotal'] = $data['price'] * $data['quantity'];
                    $this->tbody_content .= (string) view("components.purchase-order-row", $data);
                }
            }
            ($this->tbody_content);
        }
    }

    private function setLastTableContent($request)
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
                $data['form'] = 'purchase-order';
                $this->tbody_content .= (string) view("components.purchase-order-row", $data);
            }
        }
    }

    public function orderReceived(Request $request)
    {
        $io_id = $request->input('io_id');

        // get processing products first
        $InventoryOrder2Product = new InventoryOrder2Product();
        $ordered_products = $InventoryOrder2Product->getProcessingProducts($io_id);

        // now the products will be delivered
        $InventoryOrder = InventoryOrder::find($io_id);
        $InventoryOrder->date_delivered = date('Y-m-d');
        $InventoryOrder->save();
        
        // insert and log
        $Product = new Product();        
        foreach ($ordered_products as $product) {
            $previous_quantity = Inventory::getStock($product->io2p_product_id);

            // insert/prodct products to inventory
            $inventory_id = $Product->addStock($product);            
            $updated_quantity = Inventory::find($inventory_id)->stock;

            // Log
            InventoryLog::log(
                $inventory_id,
                $previous_quantity,
                $updated_quantity,
                8 // 8 for add stock
            );
        }

        $request->session()->flash('success_message', 'Order received successfully!');
        return redirect()->action([InventoryController::class, 'orders']);
    }

    public function store(StorePurchaseOrderRequest $request)
    {
        $request->validated();

        $InventoryOrder = new InventoryOrder();

        $InventoryOrder->vendor = $request->input('vendor');
        $InventoryOrder->company_name = $request->input('company');
        $InventoryOrder->contact_detail = $request->input('contact');
        $InventoryOrder->address = $request->input('address');
        $InventoryOrder->tax = $request->input('tax');
        $InventoryOrder->shipping_fee = $request->input('shipping_fee');
        $InventoryOrder->eta = $request->input('eta');
        $InventoryOrder->action_id = 1; // 1 = Order Processing

        $InventoryOrder->save();

        $transaction_id = $InventoryOrder->id; // id of latest insert

        $InventoryOrder2Product = new InventoryOrder2Product();
        $InventoryOrder2Product->insert_products($request, $transaction_id);

        $request->session()->flash('msg_success', 'Purchase order submitted!');
        $request->session()->forget('get_half_stock');
        return redirect()->action([InventoryController::class, 'orders']);
    }

    public function inventorySearch(Request $request)
    {
        $search = $request->input('q');
        $category_id = $request->input('category_id');
        $stock_filter = $request->input('stock_filter');
        $data['url_params'] = "q=$search&category_id=$category_id&stock_filter=$stock_filter";
        $Inventory = new Inventory();
        DB::enableQueryLog();
        $data['products'] = $Inventory->getProducts($search, $category_id, $stock_filter);
        $rows = (string) view("components.inventory-list", $data);
        $data['d_none'] = count($data['products']) ? 'd-none' : '';
        $table_empty = (string) view("layouts.empty-table", $data);
        $links = (string) $data['products']->links();
        $row_count = count($data['products']);
        $response = [
            'rows_html' => $rows,
            'links_html' => $links,
            'table_empty' => $table_empty,
            'row_count' => $row_count,
            'table_color' => $request->input('table_color'),
            'last_query' => DB::getQueryLog(),            
        ];
        $response = json_encode($response);
        return Response()->json($response);
    }

    public function purchaseOrderSearch(Request $request)
    {
        $tbody_content = '';
        $item_code = $request->input('item_code');
        DB::enableQueryLog();
        $product = Inventory::select(
            DB::raw('p.id p_id, p.item_code, p.name p_name,
        p.description, p.price, p.unit, p.expiration_date, p.stock p_stock,
        c.name c_name')
        )
            ->from('product as p')
            ->leftJoin('product_category as c', 'p.category_id', '=', 'c.id')
            ->where('p.item_code', $item_code)
            ->whereNull('p.deleted_at')
            ->whereIn('p.id', function ($query) {
                $query->select(DB::raw('max(id)'))
                    ->from('product')
                    ->groupBy('item_code');
            })
            ->first();

        if (!empty($product)) {
            $data['p_id'] = $product->p_id;
            $data['code'] = $product->item_code;
            $data['name'] = $product->p_name;
            $data['description'] = $product->description;
            $data['quantity'] = $request->input('quantity');
            $data['price'] = $product->price;
            $data['subtotal'] = $data['price'] * $data['quantity'];
            $data['form'] = 'purchase-order';
            $tbody_content = (string) view("components.purchase-order-row", $data);
        }

        $response = [
            'result' => $product,
            'tbody' => $tbody_content,
            'table_empty' => (string) view('layouts.empty-table'),
            'last_query' => DB::getQueryLog(),
        ];

        $response = json_encode($response);
        return Response()->json($response);
    }
}
