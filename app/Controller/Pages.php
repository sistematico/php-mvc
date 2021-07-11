<?php

namespace App\Controller;

use \App\Core\View;

class Pages extends View
{
    public static function home()
    {
        return View::render('home', [
            'name' => 'PHP MVC'
        ]);
    }
}