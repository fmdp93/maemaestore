<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\ProductsTrait;
use Illuminate\Support\Facades\Auth;

class CashierProductsController extends Controller
{
    use ProductsTrait;
    public static $page_path = '/cashier/products';
    public static $product_search_url = '/cashier/products/search';

    public function index(Request $request){
        $data['heading'] = 'Products';
        $data['categories'] = Category::all();
        $data['search'] = $request->input('q');
        $data['category_id'] = $request->input('category_id');
        
        $ProductModel = new Product();
        $data['products'] = $ProductModel->getProductsInCashier($data['search'], $data['category_id'], self::$page_path);
        $data['form_id'] = "products";
        $data['d_none'] = empty(count($data['products'])) ?: 'd-none';
        $data['page_path'] = self::$page_path;

        return view('pages.cashier.products', $data);
    }

    public function search(Request $request)
    {
        $search = $request->input('q');
        $category_id = $request->input('category_id');
        $data['action'] = $request->input('action');
        $ProductModel = new Product();
        $data['products'] = $ProductModel->getProductsInCashier($search, $category_id, self::$page_path);
        $rows = (string) view("components.cashier.products-list", $data);
        $table_empty = (string) view("layouts.empty-table", $data);
        $links = (string) $data['products']->links();
        $row_count = count($data['products']);
        $response = [
            'rows_html' => $rows,
            'links_html' => $links,
            'table_empty' => $table_empty,
            'row_count' => $row_count,
        ];
        $response = json_encode($response);
        return Response()->json($response);
    }
}
