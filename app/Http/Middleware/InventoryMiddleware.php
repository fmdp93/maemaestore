<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $Inventory = new Inventory();
        $half_stock = $Inventory->getHalfStock();
        return $next($request);
    }
}
