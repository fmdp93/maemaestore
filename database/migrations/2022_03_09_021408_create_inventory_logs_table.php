<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id');
            $table->integer('previous_quantity');
            $table->integer('updated_quantity');
            $table->integer('action_id');
            $table->dateTime('date_and_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_log');
    }
}
