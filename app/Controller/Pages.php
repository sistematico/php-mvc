<?php

namespace App\Controller;

use \App\Core\View;

class Pages
{
    public static function home()
    {
        return View::render('home', [
            'name' => 'PHP MVC'
        ]);
    }
}