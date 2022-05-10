<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    public $timestamps = false;

    public function isAdmin(){
        return Auth::user()->role_id === 1; //admin
    }

    public function isCashier(){
        return Auth::user()->role_id === 2; //cashier
    }
    
}    
