<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class ProductNewPriceColumnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = Product::all();
        $mark_up = Config::get('app.markup_price');
        foreach($model as $row){
            Product::where('id', $row->id)
                ->update([
                    'price' => increaseNumByPercent($row->price, $mark_up),
                    'base_price' => $row->price,
                    'tax' => $mark_up,                    
                ]);
        }
    }
}
