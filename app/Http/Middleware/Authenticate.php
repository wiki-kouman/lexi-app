<?php

namespace App\Http\Middleware;

use App\Services\OAuthService;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        $allowedRoutes = [ '/', 'login', 'logout', 'oauth-callback' ];

        if(!OAuthService::isLoggedIn() && !in_array($request->path(), $allowedRoutes)){
            return redirect('/');
        }

        return $next($request);
    }

}
