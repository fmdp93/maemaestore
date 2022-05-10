<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PosTransaction2Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_transaction2product', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('pos_transaction_id');            
            $table->integer('product_id');   
            $table->integer('quantity');   
            $table->integer('refunded_quantity');   
            $table->float('price');
            $table->datetime('refunded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_transaction2product');
    }
}
