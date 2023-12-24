<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch (Auth::user()->rol) {
                    case 'cliente':
                        return redirect('/');
                    case 'admin':
                        return redirect('/dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
