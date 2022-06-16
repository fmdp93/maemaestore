<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\PINController;

class PinMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $action)
    {                
        if(!session('pin')){        
            session()->flash('initial_message', 'Enter PIN first');
            $referrer = urlencode(url()->full());        
            $url = $action . '?referrer=' . $referrer;            
            return redirect($url);
        }
        
        // session()->flash('pin', session('pin'));
        session()->keep('pin');
        return $next($request);
    }
}
