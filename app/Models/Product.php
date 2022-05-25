<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    public $timestamps = false;

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function addStock($product)
    {
        $Inventory = Inventory::where('product_id', $product->io2p_product_id)
            ->get();

        if (count($Inventory) === 0) {
            // insert              
            $Inventory = new Inventory();
            $Inventory->product_id = $product->p_id;
            $Inventory->stock = $product->io2p_quantity;
            $Inventory->save();
            $inventory_id = $Inventory->id;
        } else {
            // update
            $Inventory = new Inventory();
            $Inventory = $Inventory->where('product_id', $product->p_id);
            $inventory_id = $Inventory->first()->id;

            $Inventory->update([
                'stock' => DB::raw('stock + ' . $product->io2p_quantity)
            ]); // returns 1 after updating
        }

        return $inventory_id;
    }

    public function getProducts($search, $category_id, $page_path)
    {
        $Products = Product::select(
            DB::raw('p.id p_id, p.item_code, p.name p_name,
        p.description, c.name c_name, p.price, p.stock, p.unit, p.expiration_date')
        )
            ->from('product as p')
            ->leftJoin('product_category as c', 'p.category_id', '=', 'c.id')
            ->orWhere(function ($query) use ($search) {
                $query->where('p.item_code', 'LIKE', "%$search%")
                    ->orWhere('p.name', 'LIKE', "%$search%");
            })
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('c.id', $category_id);
            })
            ->where('p.deleted_at', null)
            ->whereIn('p.id', function ($query) {
                $query->select(DB::raw('max(id)'))
                    ->from('product')
                    ->whereNull('deleted_at')
                    ->groupBy('item_code');
            })
            ->orderBy('p.id', 'desc')
            ->paginate(Config::get('constant.per_page'))
            ->withPath($page_path)
            ->appends(
                [
                    'q' => $search,
                    'category_id' => $category_id,
                ]
            )
            ->withQueryString();
        return $Products;
    }

    public static function getProduct($id)
    {
        // $product = new Product();
        // var_dump($id);

        return Product::select(DB::raw("p.id p_id,
            s.id s_id, s.vendor, s.company_name, s.contact_detail, s.address"))
            ->from("product as p")
            ->leftJoin("supplier as s", "s.id", "=", "p.supplier_id")
            ->where("p.id", $id);
    }
}
