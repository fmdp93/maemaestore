<?php

namespace Database\Factories;

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
        return [
            'pos_transaction_id' => rand(1,100),
            'product_id' => rand(1,100),
            'quantity' => rand(1,10),
            'refunded_quantity' => 0,
            'price' => rand(10,20),
            'refunded_at' => null
        ];
    }
}
