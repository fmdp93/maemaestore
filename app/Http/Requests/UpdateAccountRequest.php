<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\OldPasswordMatches;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
        $rules = [            
            'old_pw' => ['exclude_without:new_pw', new OldPasswordMatches],
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'age' => 'required|integer|min:1',
            'contact_num' => 'required',
        ];

        $rules['username'] = $this->usernameRule();        
        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('new_pw', Password::defaults(), function ($input) {
            return $input->new_pw != "";
        });
    }

    private function usernameRule(){
        $old_username = User::find(Auth::id())->username;
        $new_username = $this->input('username');

        return $old_username == $new_username ? '' : 'required|alpha_num|unique:user,username';        
    }
}
