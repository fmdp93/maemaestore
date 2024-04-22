<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Product::class;

    public function definition()
    {
        /**
         * @var int $category_id
         */
        $category_id = Category::where('id', rand(1, SEED_COUNT))->first()->id;
        $this->faker->locale('en_US');
        $price = rand(100, 1000) + rand(1, 100) * .1;
        $markup = Config::get('app.markup_price');
        return [
            'item_code' => $this->faker->ean13(),
            'category_id' => $category_id,
            'stock' => 100,
            'price' => $price,
            'name' => $this->faker->productName($category_id),
            'unit' => 'piece',
            'description' => $this->faker->realText(),
            'expiration_date' => $this->faker->date(),
            'supplier_id' => rand(1,10),
            'base_price' => $price / (1 + $markup/100),
            'markup' => $markup,
        ];
    }
}
