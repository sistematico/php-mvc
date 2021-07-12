<?php

namespace App\Controller;

use \App\Core\View;

class AdminPage extends View
{

    public static function getPage($title, $content)
    {
        return View::render('admin/page',[

        ]);
    }

}