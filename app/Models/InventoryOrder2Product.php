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

    public function insert_products($request, $transaction_id){        
        foreach($request->input('product_id') as $key => $product_id){
            $InventoryOrder2Product = new InventoryOrder2Product();
            $InventoryOrder2Product->transaction_id = $transaction_id;
            $InventoryOrder2Product->product_id = $product_id;
            $InventoryOrder2Product->quantity = $request->input('quantity')[$key];
            $InventoryOrder2Product->price = $request->input('price')[$key];
            $InventoryOrder2Product->save();            
        }        
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

    public function getProcessingProducts($transaction_id, $supplier_id)
    {
        DB::enableQueryLog();
        $query = $this::select(DB::raw('
            io.id io_id,
            io2p.id io2p_id, io2p.product_id io2p_product_id,
                io2p.price io2p_price, io2p.quantity io2p_quantity,
            c.name c_name,
            p.id p_id, p.name p_name, p.item_code p_item_code, p.description p_desc,
                p.expiration_date,
                p.base_price, p.tax p_tax, p.markup, p.price selling_price'))
            ->from('inventory_order2_product as io2p')
            ->join('product as p', 'p.id', '=', 'io2p.product_id')
            ->join('product_category as c', 'c.id', '=', 'p.category_id')
            ->join('inventory_order as io', 'io.id', '=', 'io2p.transaction_id')
            ->where('io2p.transaction_id', $transaction_id)
            ->where('p.supplier_id', $supplier_id)
            ->whereNull('io2p.status_id');

        // $query->get();
        // print_r(DB::getQueryLog());
        // die();
        return $query->get();
    }
}
