<?php

\App\Core\View::init([
    'SITENAME'=>SITENAME,
    'URL'=>URL,
    'YEAR'=> date('Y')
]);

\App\Http\Middleware\Queue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
    'admin-login' => \App\Http\Middleware\AdminLogin::class,
    'admin-logout' => \App\Http\Middleware\AdminLogout::class,
    'user-login' => \App\Http\Middleware\UserLogin::class,
    'user-logout' => \App\Http\Middleware\UserLogout::class
]);

\App\Http\Middleware\Queue::setDefault(['maintenance']);