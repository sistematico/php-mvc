<?php

namespace App\Http\Middleware;

use \App\Session\User\Login as SessionUserLogin;

class RequireUserLogout
{
    public function handle($request, $next) {
        if (SessionUserLogin::isLogged()) {
            $request->getRouter()->redirect('/user');
        }

        return $next($request);
    }
}