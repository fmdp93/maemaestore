<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\InventoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = "inventory";

    public $timestamps = false;

    public function getProducts($search, $category_id, $expiry, $page_path, $stock_filter = '')
    {
        DB::enableQueryLog();
        $Products = Inventory::select(
            DB::raw('p.id p_id, p.item_code, p.name p_name,
        p.description, p.price, p.unit, p.expiration_date, p.stock p_stock,
        s.vendor, s.company_name,
        i.id i_id, i.stock i_stock,
            (SELECT SUM(i2.stock) sum_i_stock
                FROM inventory i2
                INNER JOIN product p2
                ON p2.id = i2.product_id
                WHERE p2.item_code = p.item_code
                GROUP BY p2.item_code
                LIMIT 1) sum_i_stock,
        c.name c_name')
        )
            ->from('inventory as i')
            ->leftJoin('product as p', 'i.product_id', '=', 'p.id')
            ->leftJoin('product_category as c', 'c.id', '=', 'p.category_id')
            ->leftJoin('supplier as s', 's.id', '=', 'p.supplier_id')
            ->orWhere(function ($query) use ($search) {
                $query->where('p.item_code', 'LIKE', "%$search%")
                    ->orWhere('p.name', 'LIKE', "%$search%");
            })
            ->whereNull('status_id') // Null is default (not archived)
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('c.id', $category_id);
            })
            ->when($stock_filter, function ($query) use ($stock_filter) {
                $this->filter_stock($query, $stock_filter);
            })
            ->orderBy('p.expiration_date', $expiry)
            ->orderBy('p.name', 'asc')
            ->paginate(Config::get('constant.per_page'))
            ->withPath($page_path)
            ->appends(
                [
                    'q' => $search,
                    'category_id' => $category_id,
                ]
            )
            ->withQueryString();
        // $Products->get();
        // echo '<pre>';
        // print_r(DB::getQueryLog());
        // echo '</pre>';
        // die();
        return $Products;
    }

    public function getHalfStock()
    {
        $Inventory = Inventory::select(
            DB::raw('p.id p_id, p.item_code, p.name p_name,
        p.description, p.price, p.unit, p.expiration_date, p.stock p_stock,
        SUM(i.stock) i_stock,
        c.name c_name')
        )
            ->from('inventory as i')
            ->leftJoin('product as p', 'i.product_id', '=', 'p.id')
            ->leftJoin('product_category as c', 'c.id', '=', 'p.category_id')
            ->whereNull('status_id')
            ->groupBy('p.item_code')
            ->orderBy('p.id', 'desc')
            ->havingRaw('i_stock <= (.5 * p.stock)')
            ->get();

        return $Inventory;
    }

    private function filter_stock($query, $stock_filter)
    {
        if ($stock_filter == 'normal') {
            $query->havingRaw('sum_i_stock > (.5 * p.stock)');
        } else if ($stock_filter == 'half') {
            $query->havingRaw('(sum_i_stock > (.3 * p.stock)) and (sum_i_stock <= (.5 * p.stock))');
        } else if ($stock_filter == 'low') {
            $query->havingRaw('sum_i_stock <= (.3 * p.stock)');
        }
        return $query;
    }

    public function returnStock($id, $quantity)
    {
        Inventory::where('product_id', $id)
            ->update([
                'stock' => DB::raw("stock + $quantity")
            ]);
    }

    public static function getStock($product_id)
    {
        $Inventory = Inventory::where('product_id', $product_id)
            ->first();

        return $Inventory !== null ? $Inventory->stock : 0;
    }

    public static function getStockOf($item_code){
        $stock = Inventory::select(DB::raw('SUM(i.stock) max_stock'))
            ->from("inventory as i")
            ->join("product as p", 'p.id', '=', 'i.product_id')
            ->where('p.item_code', $item_code)
            ->whereNull('deleted_at')
            ->groupBy('p.item_code')
            ->first()
            ;
        
        return $stock !== null ? $stock->max_stock : 0;
    }

    public function getArchivedInvItems($search, $page_path)
    {
        $Archives = Inventory::select(
            DB::raw('p.id p_id, p.item_code, p.name p_name,
        p.description, p.price, p.unit, p.expiration_date, p.stock p_stock,
        i.id i_id, i.stock i_stock,
        c.name c_name')
        )
            ->from('inventory as i')
            ->leftJoin('product as p', 'i.product_id', '=', 'p.id')
            ->leftJoin('product_category as c', 'c.id', '=', 'p.category_id')
            ->orWhere(function ($query) use ($search) {
                $query->where('p.item_code', 'LIKE', "%$search%")
                    ->orWhere('p.name', 'LIKE', "%$search%");
            })
            ->where('status_id', 16) // Archived = 16
            ->orderBy('i.id', 'desc')
            ->paginate(Config::get('constant.per_page'))
            ->withPath($page_path)
            ->appends(
                [
                    'q' => $search,
                ]
            );

        return $Archives;
    }

    public static function reduceInventoryStock(){
        
    }
}
