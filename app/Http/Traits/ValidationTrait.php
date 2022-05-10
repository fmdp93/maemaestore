<?php 
namespace App\Http\Traits;

use App\Models\Product;
use Illuminate\Support\Facades\Config;

trait ValidationTrait{
    private function quantityRequiredNotNegative($attribute, $values, $fail){
        foreach($values as $key => $val){
            if(empty($val)){
                $fail("Quantity is required");                
            }else if(!is_int_not_negative($val)){
                $fail("Invalid quantity");                
            }
        }
    }

    private function arrayOfInt($attribute, $values, $fail){        
        foreach($values as $val){            
            if(!is_int_not_negative($val)){
                $fail("Invalid $attribute");
            }
        }
    }

    private function validatePriceArray($attribute, $values, $fail){
        $prices = $this->input('price');
        $product_ids = $this->input("product_id");
        foreach($prices as $key => $price){
            $real_price = Product::find($product_ids[$key])->price;
            $markup_price = Config::get('app.markup_price');            
            $dbmu_price = $real_price + $real_price * $markup_price;
            
            if(sprintf("%.2f", $price) != sprintf("%.2f", $dbmu_price)){
                $fail("Price was modified");
            }
        }
    }
}