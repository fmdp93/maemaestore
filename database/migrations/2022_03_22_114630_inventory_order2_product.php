<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoryOrder2Product extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // List of products in purchase order form
        Schema::create('inventory_order2_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('product_id');
            $table->integer('quantity'); //ordered quantity            
            $table->decimal('price');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_order2_product');
    }
}
