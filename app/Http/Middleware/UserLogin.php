<?php

namespace App\Http\Middleware;

use \App\Core\Session;

class UserLogin
{
    public function handle($request, $next)
    {
        if (!Session::userIsLogged()) {
            $request->getRouter()->redirect('/users/login');
        }
        return $next($request);
    }
}