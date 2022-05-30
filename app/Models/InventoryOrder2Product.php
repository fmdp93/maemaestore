<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryOrder2Product extends Model
{
    use HasFactory;

    protected $table = 'inventory_order2_product';

    public $timestamps = false;

    public function insert_products($transaction_id, $supplier_id)
    {
        DB::enableQueryLog();
        // max_stock came from max stock of latest product
        $products = Product::select(DB::raw('            
            ((SELECT stock max_stock FROM product 
                WHERE item_code = p.item_code order by id desc limit 1) 
                - SUM(IF(i.stock is NULL, 0, i.stock))) order_quantity,
             MAX(p.id) last_product_id, p.price'))
            ->from('product as p')
            ->leftJoin('inventory as i', 'i.product_id', '=', 'p.id')
            ->where('supplier_id', $supplier_id)
            ->whereNull('i.status_id') //inventory product not archive
            ->having('order_quantity', '>', 0)
            ->groupBy('p.item_code');
        // $products->get();
        // dd(DB::getQueryLog());
        $row_count = 0;
        foreach ($products->get() as $key => $product) {
            // if quantity is overstock
            if ($product->order_quantity < 0) {
                continue;
            }

            $InventoryOrder2Product = new InventoryOrder2Product();
            $InventoryOrder2Product->transaction_id = $transaction_id;
            $InventoryOrder2Product->product_id = $product->last_product_id;
            $InventoryOrder2Product->quantity = $product->order_quantity;
            $InventoryOrder2Product->price = $product->price;
            $InventoryOrder2Product->save();
            $row_count++;
        }
        return $row_count > 0 ? true : false;
    }

    public static function getOrderedProduct($wheres)
    {
        $query = self::select(DB::raw('
            io2p.transaction_id,
            p.id p_id, p.item_code, p.category_id, p.stock, p.price, 
            p.name, p.unit, p.description, p.supplier_id, p.expiration_date'))
            ->from('inventory_order2_product as io2p')
            ->join('product as p', 'p.id', '=', 'io2p.product_id');

        foreach ($wheres as $fields) {
            $query->where($fields->column_name, $fields->operator, $fields->value);
        }
        
        $query->whereNull('deleted_at')
            ->orderBy('p.id', 'desc');

        return $query;
    }

    public function getProcessingProducts($transaction_id)
    {
        DB::enableQueryLog();
        $query = $this::select(DB::raw('
            io.id io_id,
            io2p.id io2p_id, io2p.product_id io2p_product_id,
                io2p.price io2p_price, io2p.quantity io2p_quantity,
            c.name c_name,
            p.id p_id, p.name p_name, p.item_code p_item_code, p.description p_desc,
                p.expiration_date'))
            ->from('inventory_order2_product as io2p')
            ->join('product as p', 'p.id', '=', 'io2p.product_id')
            ->join('product_category as c', 'c.id', '=', 'p.category_id')
            ->join('inventory_order as io', 'io.id', '=', 'io2p.transaction_id')
            ->where('io2p.transaction_id', $transaction_id)
            ->whereNull('io2p.status_id');

        // $query->get();
        // print_r(DB::getQueryLog());
        // die();
        return $query->get();
    }
}
