<?php

namespace App\Controller;

use \App\Core\View;
use \App\Model\User;
use \App\Core\Session;

class Pages extends View
{
    public static function home()
    {
        return parent::getPage('posts', 'Home', [
            'name' => 'PHP2 MVC'
        ]);
    }

    public static function posts()
    {
        return parent::getPage('posts', 'Posts', [
            'name' => 'PHP2 MVC'
        ]);
    }

    public static function notAllowed()
    {
        return parent::getPage('error/405', 'Erro 405');
    }

    public static function notFound()
    {
        return parent::getPage('error/404', 'Erro 404');
    }
}