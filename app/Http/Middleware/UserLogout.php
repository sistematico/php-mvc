<?php

namespace App\Http\Middleware;

use \App\Core\Session;

class UserLogout
{
    public function handle($request, $next)
    {
        if (Session::userIsLogged()) {
            $request->getRouter()->redirect('/');
        }
        return $next($request);
    }
}