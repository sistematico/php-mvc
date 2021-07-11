<?php

namespace App\Controller;

use \App\Core\View;

class Pages extends View
{
    public static function home()
    {
        return parent::main('home', 'Home', [
            'name' => 'PHP2 MVC'
        ]);
    }
}