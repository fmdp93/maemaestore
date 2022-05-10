<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class OldPasswordMatches implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        $user = User::find(Auth::id());        
        return Hash::check($value, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Old password is incorrect';
    }
}
