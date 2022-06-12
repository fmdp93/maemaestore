<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\POSTransaction2ProductModel;

class POSTransaction2ProductColumnBasePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $model = POSTransaction2ProductModel::all();
        // set base price
        foreach($model as $item){            
            if(Product::find($item->product_id) == null){
                continue;
            }
            $base_price = Product::find($item->product_id)->price;
            POSTransaction2ProductModel::where('id', $item->id)
                ->update([
                    'base_price' => $base_price,
                ]);
        }
    }
}
