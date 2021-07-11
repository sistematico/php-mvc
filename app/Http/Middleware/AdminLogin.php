<?php

namespace App\Http\Middleware;

use \App\Core\Session;

class AdminLogin
{
    public function handle($request, $next)
    {
        if (!Session::adminIsLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }
        return $next($request);
    }
}