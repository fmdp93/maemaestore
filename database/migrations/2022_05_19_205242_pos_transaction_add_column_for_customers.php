<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class PosTransactionAddColumnForCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_transaction', function (Blueprint $table) {
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->default("");
            $table->string('customer_address')->default("");
            $table->string('customer_contact_detail')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns(
            'pos_transaction',
            [
                'customer_id',
                'customer_name',
                'customer_address',
                'customer_contact_detail',
            ]
        );
    }
}
