<?php

namespace Database\Factories;

use App\Models\ConfigModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class POSTransaction2ProductModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_id = rand(1,100);
        $markup_price = ConfigModel::find(2)->value; //2 is markup_price
        $base_price = Product::find($product_id)->price;
        $price =  $base_price + $base_price * (float) $markup_price;
        return [
            'pos_transaction_id' => rand(1,100),
            'product_id' => $product_id,
            'quantity' => rand(1,10),
            'refunded_quantity' => 0,
            'price' => $price,
            'refunded_at' => null
        ];
    }
}
