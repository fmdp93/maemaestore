<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Action;
use App\Models\AccountLog;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\AddCashierRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\UpdateAdminAccountRequest;

class AccountsController extends Controller
{
    use UserTrait;  

    public static $action_class = AccountsController::class;
    public static $user_content = 'admin_content';
    public static $include_content = 'components.admin.content';    

    public function index()
    {
        $data['heading'] = "Accounts";
        $data['title'] = "Accounts";
        $data['accounts'] = User::where('id', '!=', 1)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(Config::get('constant.per_page'))
            ->withPath('/accounts')
            ->withQueryString();

        return view('pages.admin.accounts', $data);
    }

    public function addCashier()
    {
        $data['heading'] = "Add Cashier";
        $data['title'] = "Add Cashier";

        return view('pages.admin.add-cashier', $data);
    }

    public function addCashierSubmit(AddCashierRequest $request)
    {
        $request->validated();

        $user = new User();
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->age = $request->input('age');
        $user->contact_num = $request->input('contact_num');
        $user->role_id = 2;
        $user->save();

        AccountLog::log($user->id, 10); // 10 added cashier;

        $request->session()->flash('msg_success', 'Cashier successfully created!');
        return redirect()->action([AccountsController::class, 'index']);
    }   

    public function deleteCashier(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $user->deleted_at = date('Y-m-d h:i:s');
        $user->save();
        
        AccountLog::log($user_id, 12);
        return redirect(action([AccountsController::class, 'index']) . "?page=" . $request->input('page'));
    }
}
