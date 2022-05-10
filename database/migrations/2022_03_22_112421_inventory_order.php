<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Summary of purchase order form
        Schema::create('inventory_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor');
            $table->string('company_name');
            $table->string('contact_detail');
            $table->string('address');                
            $table->decimal('tax');
            $table->decimal('shipping_fee');
            $table->date('eta');
            $table->date('date_delivered')
                ->nullable()
                ->default(null);            
            $table->integer('action_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_order');
    }
}
