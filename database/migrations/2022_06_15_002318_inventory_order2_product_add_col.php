<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoryOrder2ProductAddCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_order2_product', function(Blueprint $table){
            $table->dateTime('date_received')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('inventory_order2_product', 'date_received'))
            Schema::dropColumns('inventory_order2_product', ['date_received']);
    }
}
