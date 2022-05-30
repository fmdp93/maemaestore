<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductAddColumnForPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function(Blueprint $table){
            $table->integer('stock')->comment('Max stock of a product')->change(); // max stock of product
            $table->decimal('price')->comment('Selling price of an item')->change();
            $table->float('base_price');
            $table->float('tax')->comment('Percentage');
            $table->float('markup')->comment('Percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('product', ['base_price', 'tax', 'mark_up']);
    }
}
