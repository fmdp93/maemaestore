<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PosTransaction2ProductAddColumnForDiscounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_transaction2product', function(Blueprint $table){
            $table->float("senior_discount");
            $table->float("promo_discount");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('pos_transaction2product', [
            'senior_discount',
            'promo_discount',
        ]);
    }
}
