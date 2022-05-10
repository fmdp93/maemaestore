<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\AddCashierRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\UpdateAdminAccountRequest;
use App\Http\Traits\UserTrait;

class CashierAccountsController extends Controller
{
    use UserTrait;  

    public static $action_class = CashierAccountsController::class;
    public static $user_content = 'cashier_content';
    public static $include_content = 'components.cashier.content';
}