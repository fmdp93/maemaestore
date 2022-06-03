<?php

namespace Database\Seeders;

use App\Models\POSTransaction2ProductModel;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PosTransaction2ProductSellingPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        foreach($products as $product){
            POSTransaction2ProductModel::where('product_id', $product->id)
                ->update(
                    [
                        'selling_price' => $product->price,
                    ]
                );
        }
    }
}
