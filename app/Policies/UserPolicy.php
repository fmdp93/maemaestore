<?php

namespace App\Policies;

use App\Models\User;
use App\Http\Controllers\PageUnauthorized;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function do_admin(User $user)
    {   
        if($user->isAdmin()){            
            return true;
        }
    }

    public function do_cashier(User $user)
    {
        if($user->isCashier()){
            return true;
        }
    }

    // public function before(User $user){
    //     if($user->isAdmin()){
    //         return true;
    //     }
    // }
}
