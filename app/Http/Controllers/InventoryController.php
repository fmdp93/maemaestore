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
    public static $page_path = '/inventory';

    public function index(Request $request)
    {
        $data['heading'] = 'Inventory';
        // Get parameters
        $data['categories'] = Category::all();
        $data['search'] = $request->input('q');
        $stock_filter = $request->input('stock_filter');
        $data['category_id'] = $request->input('category_id');
        $data['expiry'] = $request->input('expiry');
        $data['archive_action'] = route('inventory_archive');
        // EOQ
        $Inventory = new Inventory();
        $data['half_stock_products'] = $Inventory->getHalfStock();

        // Inventory        
        $expiry = getExpiryOrderBy($request->input('expiry'));
        $data['products'] = $Inventory->getProducts($data['search'], $data['category_id'], $expiry, self::$page_path, $stock_filter);
        $data['d_none'] = count($data['products']) ? 'd-none' : '';
        $data['form'] = 'purchase-order';
        $data['product_search_url'] = "/inventory/search";
        $data['show_action'] = true;
        $data['content'] = 'admin_content';
        $data['components_content'] = 'components.admin.content';

        return view('pages.admin.inventory', $data);
    }
    /**
     * Archive a product in the inventory
     * 
     * @return redirect
     */
    public function archive(Request $request)
    {
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
    /**
     * List of archived products from inventory
     */
    public function archives(Request $request)
    {
        $search = $request->input('q');

        $data['heading'] = "Inventory Archive";
        $data['title'] = "Inventory Archive";
        $data['search'] = $search;
        $data['unarchive_inv_item_action'] = route('inventory_unarchive');

        $Inventory = new Inventory();
        $data['archive_inv_items'] = $Inventory->getArchivedInvItems($search, '/inventory/archives');
        $data['d_none'] = count($data['archive_inv_items']) ? 'd-none' : '';

        return view('pages.admin.archives', $data);
    }

    /**
     * 
     */
    public function archiveSearch(Request $request)
    {
        $search = $request->input('q');

        $Inventory = new Inventory();

        DB::enableQueryLog();
        $data['archive_inv_items'] = $Inventory->getArchivedInvItems($search, '/inventory/archives');
        $data['unarchive_inv_item_action'] = $request->input('unarchive_inv_item_action');
        $data['search'] = "$search";
        $rows = (string) view("components.admin.archive_inv_item-list", $data);

        $data['d_none'] = count($data['archive_inv_items']) ? 'd-none' : '';
        $table_empty = (string) view("layouts.empty-table", $data);
        $links = (string) $data['archive_inv_items']->links();
        $row_count = count($data['archive_inv_items']);
        $response = [
            'rows_html' => $rows,
            'links_html' => $links,
            'table_empty' => $table_empty,
            'row_count' => $row_count,
            'last_query' => DB::getQueryLog(),
        ];
        $response = json_encode($response);
        return Response()->json($response);
    }

    public function unarchive(Request $request)
    {
        Inventory::where('id', $request->input('archive_inv_item_id'))
            ->update([
                'status_id' => null,
            ]);

        $params = [
            'q' => $request->input('search'),
            'page' => $request->input('page'),
        ];

        $request->session()->flash('msg_success', 'Unarchive succesful!');
        $back = route('inventory_archives', $params);
        // dd($back);
        return redirect($back);
    }

    public function orders(Request $request)
    {
        $data['heading'] = 'Inventory Orders';
        $InventoryOrder = new InventoryOrder();
        $data['inventory_orders'] = $InventoryOrder->getProcessing();

        return view('pages.admin.inventory-orders', $data);
    }

    public function getInventoryOrderProcessing(Request $request)
    {
        $InventoryOrder = new InventoryOrder();
        $data['inventory_orders'] = $InventoryOrder->getProcessing();

        $view = (string) view('components.admin.inventory-orders-list', $data);
        $response = [
            'inventory_orders_list' => $view,
        ];
        $response = json_encode($response);
        return Response()->json($response);
    }

    /**
     * Gets Inventory Order product details
     * 
     * @return Response()->json($response);
     */
    public function orderProducts(Request $request)
    {
        $io_id = $request->input('io_id');
        $supplier_id = $request->input('supplier_id');
        $InventoryOrder2Product = new InventoryOrder2Product();
        $data['io_products'] = $InventoryOrder2Product->getProcessingProducts($io_id, $supplier_id);
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
        $io2p_id = $request->input('io2p_id');
        $input_expiration_date = $request->input('expiration_date');
        $quantity = $request->input('quantity');
        $item_code = $request->input('item_code');
        $transaction_id = $request->input('transaction_id');
        $product_id = $request->input('product_id');

        $wheres = [
            (object) [
                'column_name' => 'item_code',
                'operator' => '=',
                'value' => $item_code,
            ],
            (object) [
                'column_name' => 'expiration_date',
                'operator' => '=',
                'value' => $input_expiration_date,
            ],
        ];
        $io2p = InventoryOrder2Product::getOrderedProduct($wheres)->first();
        $existing_product_expiration_date = "";
        if ($io2p !== null) {
            $existing_product_expiration_date = $io2p->expiration_date;
        }

        // different expiration, new item to product
        if ($input_expiration_date != $existing_product_expiration_date) {
            $wheres = [
                (object) [
                    'column_name' => 'item_code',
                    'operator' => '=',
                    'value' => $item_code,
                ],
            ];
            $io2p = InventoryOrder2Product::getOrderedProduct($wheres)->first();
            $Product = new Product();
            $Product->item_code = $io2p->item_code;
            $Product->category_id = $io2p->category_id;
            $Product->stock = $io2p->stock;
            $Product->price = $io2p->price;
            $Product->name = $io2p->name;
            $Product->unit = $io2p->unit;
            $Product->description = $io2p->description;
            $Product->supplier_id = $io2p->supplier_id;
            $Product->expiration_date = $input_expiration_date;
            $Product->save();

            $product_id = $Product->id;
        }

        $previous_quantity = Inventory::getStock($product_id);

        // new inventory item or update inventory
        $inventory_id = Product::addStock($product_id, $quantity);

        $updated_quantity = Inventory::find($inventory_id)->stock;

        // Order received for a product
        InventoryOrder2Product::where('id', $io2p_id)
            ->update([
                'status_id' => 2, //order received
                'received_quantity' => $quantity,
            ]);

        DB::enableQueryLog();

        // if all products delivered, save date_delivered to InventoryOrder
        $InventoryOrder2Product = InventoryOrder2Product::where('transaction_id', $transaction_id)
            ->whereNull('status_id');

        if (count($InventoryOrder2Product->get()) == 0) {
            InventoryOrder::where('id', $transaction_id)
                ->update([
                    'date_delivered' => date('Y-m-d'),
                ]);
        }

        // Log
        InventoryLog::log(
            $inventory_id,
            $previous_quantity,
            $updated_quantity,
            8 // 8 for add stock
        );

        $response = [];
        $response = json_encode($response);
        return Response()->json(($response));
    }

    public function orderCancel(Request $request)
    {
        $inventory_order_id = $request->input('io_id');
        InventoryOrder::where('id', $inventory_order_id)
            ->delete();
        InventoryOrder2Product::where('transaction_id', $inventory_order_id)
            ->delete();
        $request->session()->flash('msg_success', 'Order canceled successfully!');
        return back();
    }
    /**
     * Order products for inventory
     * 
     * @return redirect
     */
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


        $message = 'Purchase order submitted!';

        $request->session()->flash('msg_success', $message);
        $request->session()->forget('get_half_stock');
        return back();
    }

    public function inventorySearch(Request $request)
    {
        $search = $request->input('q');
        $category_id = $request->input('category_id');
        $stock_filter = $request->input('stock_filter');
        $expiry_filter = $request->input('expiry');
        $data['archive_action'] = $request->input('archive_action');
        $expiry = getExpiryOrderBy($request->input('expiry'));

        $Inventory = new Inventory();

        DB::enableQueryLog();
        $data['products'] = $Inventory->getProducts($search, $category_id, $expiry, self::$page_path, $stock_filter);
        $data['show_action'] = true;

        // this variable is use for redirection after an action like delete
        $data['url_params'] = "q=$search&category_id=$category_id&stock_filter=$stock_filter&expiry=$expiry_filter";
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


        $tbody_content = $this->getPurchasOrderRow($product, request()->input('quantity'));

        $params['result'] = $product;
        $params['tbody'] = $tbody_content;
        return $this->getPurcOrdResponse($params);
    }

    public function purchaseOrderSupplierSearch(Request $request)
    {
        $tbody_content = '';
        $supplier_id = $request->input('supplier_id');
        DB::enableQueryLog();
        $products = Inventory::select(
            DB::raw('
                ((SELECT stock max_stock FROM product 
                    WHERE item_code = p.item_code order by id desc limit 1) 
                    - SUM(IF(i.stock is NULL, 0, i.stock))) order_quantity,
                p.id p_id, p.item_code, p.name p_name,
                p.description, p.price, p.unit, p.expiration_date, p.stock p_stock,
                c.name c_name')
        )
            ->from('product as p')
            ->leftJoin('product_category as c', 'p.category_id', '=', 'c.id')
            ->leftJoin('inventory as i', 'i.product_id', '=', 'p.id')
            ->where('p.supplier_id', $supplier_id)
            ->whereNull('p.deleted_at')
            ->whereNull('i.status_id') //not archived
            ->whereIn('p.id', function ($query) {
                $query->select(DB::raw('max(id)'))
                    ->from('product')
                    ->groupBy('item_code');
            })
            ->having('order_quantity', '>', 0)
            ->groupBy('p.item_code');

        foreach ($products->get() as $product) {
            $tbody_content .= $this->getPurchasOrderRow($product, $product->order_quantity);
        }

        $params['tbody'] = $tbody_content;
        return $this->getPurcOrdResponse($params);
    }

    private function getPurcOrdResponse($params)
    {
        $response = [
            'table_empty' => (string) view('layouts.empty-table'),
            'last_query' => DB::getQueryLog(),
        ];

        $response = array_merge($response, $params);

        $response = json_encode($response);
        return Response()->json($response);
    }

    private function getPurchasOrderRow($product, $quantity)
    {
        if (!empty($product)) {
            $data['p_id'] = $product->p_id;
            $data['code'] = $product->item_code;
            $data['name'] = $product->p_name;
            $data['description'] = $product->description;
            $data['quantity'] = $quantity;
            $data['price'] = $product->price;
            $data['subtotal'] = $data['price'] * $data['quantity'];
            $data['form'] = 'purchase-order';
            return $tbody_content = (string) view("components.purchase-order-row", $data);
        }
    }
}
