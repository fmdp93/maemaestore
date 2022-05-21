<?php

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\POSTransaction2ProductModel;
use Illuminate\Database\Migrations\Migration;

class AddBasePriceToPosTransaction2productTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_transaction2product', function (Blueprint $table) {
            $table->float('base_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_transaction2product', function (Blueprint $table) {
            //
        });
    }
}
