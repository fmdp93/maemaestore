<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Models\POSTransactionModel;
use App\Models\POSTransaction2ProductModel;
use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Stmt\Else_;

class RRRequest extends FormRequest
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
        // echo session('pin2');
        // die();
        return [
            'product_id' => ['required', function ($attribute, $values, $fail) {
                $this->arrayOfInt($attribute, $values, $fail);
            }],
            'type' => ['required'],
            'transaction_id' => ['required'],
            'price' => ['required', function ($attribute, $values, $fail) {
                $this->validatePriceArray($attribute, $values, $fail);
            }],
            'quantity' => ['required', 'min:1', function ($attribute, $values, $fail) {
                $this->quantityRequiredNotNegative($attribute, $values, $fail);
                $this->hasEnoughStock($attribute, $values, $fail);
                $this->arrayOfInt($attribute, $values, $fail);
            }],
            'remark' => ['required'],
        ];
    }

    private function hasEnoughStock($attribute, $values, $fail)
    {
        $product_ids = $this->input("product_id");
        $quantity = $this->input("quantity");
        $item_codes = $this->input("t_item_code");
        $transaction_id = $this->input('transaction_id');
        foreach ($product_ids as $key => $product_id) {
            // group similar items
            $product_id_keys = array_keys($product_ids, $product_id);
            $table_item_quantity = 0;
            foreach ($product_id_keys as $pid_key) {
                $table_item_quantity += $quantity[$pid_key];
            }

            DB::enableQueryLog();
            // check ordered products
            $query = POSTransaction2ProductModel::select(DB::raw('
                SUM(quantity - refunded_quantity) ordered_quantity'))
                ->groupBy('product_id')
                ->where('pos_transaction_id', $transaction_id)
                ->where('product_id', $product_id);

            if (!$query->first()) {
                $fail("Product {$item_codes[$key]} not found in Transaction #: $transaction_id");
                return;
            }

            $ordered_quantity = $query->first()->ordered_quantity;

            if ($ordered_quantity < $table_item_quantity) {
                $fail("Product " . $item_codes[$key] . " exceeds ordered quantity");
                return;
            }

            // dd(DB::getQueryLog());
        }
        // die();
    }
}
