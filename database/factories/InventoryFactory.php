<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = \App\Models\Inventory::class;
    public function definition()
    {
        return [
            'product_id' => $this->faker->unique()->numberBetween(1, 500),
            'stock' => 100,
        ];
    }
}
