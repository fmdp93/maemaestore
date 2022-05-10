<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageUnauthorized;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = new User();
        $RoleModel = Role::find(Auth::user()->role_id);
        
        if($role == 'admin' && !$user->isAdmin()){
            return redirect(action([PageUnauthorized::class, $RoleModel->name]));
        }
        if($role == 'cashier' && !$user->isCashier()){
            return redirect(action([PageUnauthorized::class, $RoleModel->name]));
        }

        return $next($request);
    }
}
