<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->admin == 1) {
            return $next($request);
        }
        return redirect('/');
    }
}
