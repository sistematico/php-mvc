<?php

namespace App\Controller;

use \App\Core\View;

class Pages extends View
{
    public static function home()
    {
        return parent::page('main', 'main', 'Home', [
            'name' => 'PHP2 MVC'
        ]);
    }

    public static function posts()
    {
        return parent::page('posts', 'main', 'Home', [
            'name' => 'PHP2 MVC'
        ]);
    }
}