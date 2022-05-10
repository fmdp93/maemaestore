<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Contracts\Validation\DataAwareRule;

class UserIsActive implements ImplicitRule, DataAwareRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $data = [];
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $user = User::where('username', $this->data['username'])            
            ->whereNull('deleted_at')
            ->first();

        // dd( Hash::make($this->data['password']));
        // dd($user);
        
        return ($user->id ?? false) ? true : false;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User was deleted';
    }
}
