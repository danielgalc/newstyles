<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PeluqueroMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->rol == 'peluquero') {
            return $next($request);
        }

        return redirect('/peluquero')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
