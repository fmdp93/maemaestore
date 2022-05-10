<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = \App\Models\Product::class;

    public function definition()
    {
        return [
            'item_code' => $this->faker->ean13(),
            'category_id' => rand(1,10),
            'stock' => 100,
            'price' => rand(100, 1000) + rand(1, 100) * .1,
            'name' => $this->faker->name(),
            'unit' => 'piece',
            'description' => $this->faker->paragraph(1),
            'expiration_date' => $this->faker->date(),
        ];
    }
}
