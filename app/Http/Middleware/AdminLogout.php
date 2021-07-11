<?php

namespace App\Http\Middleware;

use \App\Core\Session;

class AdminLogout
{
    public function handle($request, $next)
    {
        if (Session::adminIsLogged()) {
            $request->getRouter()->redirect('/admin');
        }
        return $next($request);
    }
}