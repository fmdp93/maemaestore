<?php

namespace App\Http\Requests;

use App\Models\ConfigModel;
use Illuminate\Foundation\Http\FormRequest;

class PINRequest extends FormRequest
{
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
            'pin' => ['required', function($attribute, $value, $fail){
                $this->pinMatches($attribute, $value, $fail);
            }]
        ];
    }

    private function pinMatches($attribute, $value, $fail){
        $input_pin = $this->input('pin');
        $real_pin = ConfigModel::where('name', 'pin')->first()->value;         
        if($input_pin != $real_pin){            
            $fail('Incorrect PIN');
        }

        $this->session()->flash('pin', $input_pin); 
    }
}
