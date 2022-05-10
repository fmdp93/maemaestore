<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class AddCashierRequest extends FormRequest
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
            'username' => 'required|alpha_num|unique:user,username',
            'password' => ['required', Password::defaults()],
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'age' => 'required|integer|min:1',
            'contact_num' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
        ];
    }
}
