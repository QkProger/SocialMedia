<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class miniAdminAuth
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
        $isAuthenticatedAdmin = (Auth::guard('web')->check());

        //This will be excecuted if the new authentication fails.
        if ($isAuthenticatedAdmin){
            if(Auth::guard('web')->user()->role <= 2){
                return $next($request);
            }
        }
        return redirect()->route('adminLoginShow')->with('message', 'Authentication Error.');
    }
}
