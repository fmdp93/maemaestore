<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
                'item_code' => '9555657301075',
                'category_id' => '1',
                'stock' => '100',
                'price' => '200',
                'name' => 'Coffe Bean Tea Leaf Hazelnut',
                'unit' => 'piece',
                'description' => '12 sachets',
                'expiration_date' => '2023-10-10',
        ]);
        Product::factory()->count(500)->create();
    }
}
