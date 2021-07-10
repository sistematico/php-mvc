<?php

namespace App\Http\Middleware;

use \App\Session\User\Login as SessionUserLogin;

class RequireUserLogin
{
    public function handle($request, $next) {
        if (!SessionUserLogin::isLogged()) {
            $request->getRouter()->redirect('/user/login');
        }

        return $next($request);
    }
}