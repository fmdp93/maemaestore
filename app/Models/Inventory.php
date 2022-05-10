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

    public function getProducts($search, $category_id, $stock_filter = '')
    {
        $Products = Inventory::select(
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
            ->whereNull('status_id') // Null is default (not archived)
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('c.id', $category_id);
            })
            ->when($stock_filter, function ($query) use ($stock_filter) {
                $this->filter_stock($query, $stock_filter);
            })
            ->orderBy('p.id', 'desc')

            ->paginate(Config::get('constant.per_page'))
            ->withPath('/inventory')
            ->appends(
                [
                    'q' => $search,
                    'category_id' => $category_id,
                ]
            )
            ->withQueryString();
        return $Products;
    }

    public function getHalfStock()
    {
        $Inventory = Inventory::select(
            DB::raw('p.id p_id, p.item_code, p.name p_name,
        p.description, p.price, p.unit, p.expiration_date, p.stock p_stock,
        i.stock i_stock,
        c.name c_name')
        )
            ->from('inventory as i')
            ->leftJoin('product as p', 'i.product_id', '=', 'p.id')
            ->leftJoin('product_category as c', 'c.id', '=', 'p.category_id')
            ->whereRaw('i.stock <= .5 * p.stock')
            ->orderBy('p.id', 'desc')
            ->get();

        return $Inventory;
    }

    private function filter_stock($query, $stock_filter)
    {
        if ($stock_filter == 'normal') {
            $query->whereRaw('i.stock > .5 * p.stock');
        } else if ($stock_filter == 'half') {
            $query->where(function ($query) {
                $query->whereRaw('i.stock <= .5 * p.stock')
                    ->whereRaw('i.stock > .3 * p.stock');
            });
        } else if ($stock_filter == 'low') {
            $query->whereRaw('i.stock <= .3 * p.stock');
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
}
