<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */


public function handle(Request $request, Closure $next): Response
{
    // Agar user Admin hai (is_admin == 1), toh aage jane do
    if (auth()->check() && auth()->user()->is_admin) {
        return $next($request);
    }

    // Warna home page par bhej do
    return redirect('/')->with('error', 'Access Denied!');
}
}
