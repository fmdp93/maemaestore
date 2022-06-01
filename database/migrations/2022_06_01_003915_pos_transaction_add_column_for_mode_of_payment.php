<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PosTransactionAddColumnForModeOfPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_transaction', function (Blueprint $table) {
            $table->integer('mode_of_payment')->default(MODE_CASH);
            $table->string('gcash_name');
            $table->string('gcash_num');
            $table->string('cc_name');
            $table->string('cc_num');
            $table->integer('cc_term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('pos_transaction', [
            'mode_of_payment',
            'gcash_name',
            'gcash_num',
            'cc_name',
            'cc_num',
            'cc_term',
        ]);
    }
}
