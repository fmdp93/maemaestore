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

    public function getProcessingProducts($transaction_id){
        $query = $this::select(DB::raw('io2p.product_id io2p_product_id, io2p.price io2p_price, io2p.quantity io2p_quantity,
            c.name c_name,
            p.id p_id, p.name p_name, p.item_code p_item_code, p.description p_desc'))            
            ->from('inventory_order2_product as io2p')
            ->join('product as p', 'p.id', '=', 'io2p.product_id')
            ->join('product_category as c', 'c.id', '=', 'p.category_id')            
            ->where('io2p.transaction_id', $transaction_id);
        
        return $query->get();
    }
}
