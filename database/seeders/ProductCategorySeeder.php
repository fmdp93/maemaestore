<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Rice',
            'Canned Goods',
            'Instant Noodles',
            'Beverages (Soft Drinks, Juices, etc.)',
            'Cooking Oil',
            'Condiments (Soy Sauce, Vinegar, etc.)',
            'Snacks (Chips, Biscuits, etc.)',
            'Frozen Foods',
            'Fresh Produce (Fruits and Vegetables)',
            'Meat and Poultry',
            'Fish and Seafood',
            'Dairy Products (Milk, Cheese, Yogurt, etc.)',
            'Bakery Products (Bread, Pastries, etc.)',
            'Cereals and Breakfast Items',
            'Instant Coffee and Tea',
            'Canned Meat (Corned Beef, Luncheon Meat, etc.)',
            'Pasta and Noodles (Spaghetti, Macaroni, etc.)',
            'Canned Fruits and Vegetables',
            'Sauces and Dressings',
            'Baking Supplies (Flour, Sugar, etc.)',
        ];

        foreach ($categories as $category){
            Category::insert(['name' => $category]);
        }
    }
}
