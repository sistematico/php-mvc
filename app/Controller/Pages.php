<?php

namespace App\Controller;

use \App\Core\View;
use \App\Model\User;
use \App\Core\Session;

class Pages extends View
{
    public static function home()
    {
        return parent::page('posts', 'Home', [
            'name' => 'PHP2 MVC'
        ]);
    }

    public static function posts()
    {
        return parent::page('posts', 'Posts', [
            'name' => 'PHP2 MVC'
        ]);
    }

    public static function error()
    {
        return parent::page('error/404', 'Erro 404');
    }
}