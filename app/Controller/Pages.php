<?php

namespace App\Controller;

use \App\Core\View;

class Pages extends View
{
    public static function home()
    {
        $content = View::render('home', [
            'name' => 'PHP MVC'
        ]);

        return View::main('Inicio', $content);
    }
}