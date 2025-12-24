<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiAuthenticated
{
    public function handle($request, Closure $next)
    {
        if(!Session::has('jwt_token')) {
            return redirect('/login');
        }
        
        return $next($request);
    }
}
