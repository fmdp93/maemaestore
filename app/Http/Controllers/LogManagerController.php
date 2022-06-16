<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\AccountLog;
use App\Models\ProductLog;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use App\Http\Traits\PinTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class LogManagerController extends Controller
{
    public function index(Request $request)
    {
        $data['heading'] = 'Log Manager';
        $data['title'] = 'Log Manager';

        return view('pages.admin.log-manager', $data);
    }

    public function product(Request $request)
    {
        $data['heading'] = "Products' Log";
        $data['title'] = "Products' Log";
        $data['products'] = ProductLog::select(DB::raw('
            pl.date_and_time,
            p.item_code, p.name,
            a.name action_name'))
            ->from('product_log as pl')
            ->join('product as p', 'p.id', '=', 'pl.product_id')
            ->join('action as a', 'a.id', '=', 'pl.action_id')
            ->orderBy('pl.id', 'desc')
            ->paginate(Config::get('constant.per_page'));
        return view('pages.admin.product-log', $data);
    }

    public function inventory(Request $request)
    {
        $data['heading'] = "Inventory's Log";
        $data['title'] = "Inventory's Log";
        $data['inventory'] = InventoryLog::select(DB::raw('
            il.date_and_time, il.previous_quantity, il.updated_quantity,
            p.item_code, p.name,            
            a.name action_name'))
            ->from('inventory_log as il')
            ->join('inventory as i', 'i.id', '=', 'il.inventory_id')
            ->join('product as p', 'p.id', '=', 'i.product_id')
            ->join('action as a', 'a.id', '=', 'il.action_id')
            ->orderBy('il.id', 'desc')
            ->paginate(Config::get('constant.per_page'));
        return view('pages.admin.inventory-log', $data);
    }

    public function account(Request $request)
    {
        $data['heading'] = "Account's Log";
        $data['title'] = "Account's Log";
        $data['accounts'] = AccountLog::select(DB::raw('
            u.username, al.date_and_time, r.name access, a.name action_name'))
            ->from('account_log as al')
            ->join('user as u', 'u.id', '=', 'al.user_id')
            ->join('role as r', 'r.id', '=', 'u.role_id')
            ->join('action as a', 'a.id', '=', 'al.action_id')
            ->orderBy('al.id', 'desc')
            ->paginate(Config::get('constant.per_page'));

        return view('pages.admin.account-log', $data);
    }

    public function login(Request $request)
    {
        $data['heading'] = "Logins' Log";
        $data['title'] = "Logins' Log";
        $data['accounts'] = LoginLog::select(DB::raw('
            u.username, ll.date_and_time, r.name access, a.name action_name'))
            ->from('login_log as ll')
            ->join('user as u', 'u.id', '=', 'll.user_id')
            ->join('role as r', 'r.id', '=', 'u.role_id')
            ->join('action as a', 'a.id', '=', 'll.action_id')
            ->orderBy('ll.id', 'desc')
            ->paginate(Config::get('constant.per_page'));
        return view('pages.admin.login-log', $data);
    }

    public function checkPin(Request $request){
        $response['has_pin'] = true;
        session()->keep('pin');
        if(!session('pin')){
            $response['has_pin'] = false;
        }

        return Response()->json(json_encode($response));
    }
}
