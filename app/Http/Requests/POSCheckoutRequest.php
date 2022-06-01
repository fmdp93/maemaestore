<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Validation\Rule;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class POSCheckoutRequest extends FormRequest
{
    use ValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'product_id' => ['required', function ($attribute, $values, $fail) {
                $this->arrayOfInt($attribute, $values, $fail);
            }],
            'quantity' => ['required', 'min:1', function ($attribute, $values, $fail) {
                $this->quantityRequiredNotNegative($attribute, $values, $fail);
                $this->hasEnoughStock($attribute, $values, $fail);
                $this->arrayOfInt($attribute, $values, $fail);
            }],
            'price' => ['required', function ($attribute, $values, $fail) {
                $this->validatePriceArray($attribute, $values, $fail);
            }],
            'gcash_name' => ["required_if:mode_of_payment," . MODE_GCASH],
            'gcash_num' => [
                'nullable',
                "required_if:mode_of_payment," . MODE_GCASH,
                'digits:11'
            ],
            'cc_name' => ["required_if:mode_of_payment," . MODE_CREDIT_CARD],
            'cc_num' => [     
                'nullable',           
                "required_if:mode_of_payment," . MODE_CREDIT_CARD,                
                'digits_between:13,16'
            ],
            'cc_payment_term' => [
                'nullable',
                "required_if:mode_of_payment," . MODE_CREDIT_CARD,
                Rule::in([1, 2, 3]),
            ],
        ];
    }

    public function messages()
    {
        return [
            'gcash_name.required_if' => 'Name is required',
            'gcash_num.required_if' => 'GCash number is required',
            'cc_name.required_if' => 'Name is required',
            'cc_num.required_if' => 'Credit card number is required',
            'cc_payment_term.required_if' => 'Term is required',
        ];
    }

    private function hasEnoughStock($attribute, $values, $fail)
    {
        $product_ids = $this->input("product_id");
        $quantity = $this->input("quantity");
        $item_codes = $this->input("t_item_code");
        foreach ($product_ids as $key => $product_id) {
            // group similar items
            $product_id_keys = array_keys($product_ids, $product_id);
            $table_item_quantity = 0;
            foreach ($product_id_keys as $pid_key) {
                $table_item_quantity += $quantity[$pid_key];
            }

            $inventory_stock = Inventory::getStockOf($item_codes[$key]);
            if ($table_item_quantity > $inventory_stock) {
                $fail("Not enough stock for product " . $item_codes[$key]);
            }
        }
    }
}
