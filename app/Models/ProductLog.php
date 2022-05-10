<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    use HasFactory;

    protected $table = 'product_log';

    public $timestamps = false;

    public static function log($product_id, $action_id){
        $product = new ProductLog();
        $product->product_id = $product_id;
        $product->date_and_time = date("Y-m-d h:i:s");
        $product->action_id = $action_id;
        $product->save();
    }
}
