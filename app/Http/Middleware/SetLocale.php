<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App; 
use Illuminate\Support\Facades\Session; 

class SetLocale
{
  public function handle(Request $request, Closure $next): Response
{
    // Session mein 'locale' check karo, agar na mile toh 'en' lo
    $locale = session('locale', 'en'); 

    app()->setLocale($locale);

    return $next($request);
}
}