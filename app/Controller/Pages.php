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

    public static function error($title, $message = [])
    {
        return parent::getPage('error', $title, $message);
    }
}