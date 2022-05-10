<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $table = 'inventory_log';

    public $timestamps = false;

    public static function log($inventory_id, $previous_quantity, $updated_quantity, $action_id){
        $product = new InventoryLog();
        $product->inventory_id = $inventory_id;
        $product->previous_quantity = $previous_quantity;
        $product->updated_quantity = $updated_quantity;
        $product->date_and_time = date("Y-m-d h:i:s");
        $product->action_id = $action_id;
        $product->save();
    }
}
