<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_transaction', function (Blueprint $table) {
            $table->increments('id');            
            $table->decimal('amount_paid');            
            $table->dateTime('created_at');   
            $table->dateTime('voided_at');   
            $table->integer('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_transaction');
    }
}
