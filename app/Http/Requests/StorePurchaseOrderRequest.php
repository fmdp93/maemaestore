<?php

namespace App\Http\Requests;

use App\Http\Controllers\InventoryController;
use App\Http\Traits\ValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
{
    use ValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        return [
            'vendor' => 'required',
            'contact' => 'required',
            'company' => 'required',
            'address' => 'required',
            'eta' => 'required|date',
            'shipping_fee' => 'required|integer',
            'tax' => 'required|integer',
            'product_id' => ['required', function($attribute, $values, $fail){
                $this->arrayOfInt($attribute, $values, $fail);
            }],
            'quantity' => ['required', 'min:1', function($attribute, $values, $fail){
                $this->quantityRequiredNotNegative($attribute, $values, $fail);
            }, function($attribute, $values, $fail){
                $this->arrayOfInt($attribute, $values, $fail);
            }],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_id.required' => 'Product is required',            
        ];
    }
  

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // cast string to int of products_id
        // $products = [];
        // if(!empty($this->product_id)){
        //     foreach($this->product_id as $product_id){
        //         $products[] = (int) $product_id;
        //     }
        // }  

        // $this->merge([
        //     'product_id' => $products,
        // ]);

        // dd($this->product_id);
    }
}
