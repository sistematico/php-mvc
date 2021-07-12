<?php

namespace App\Controller;

use \App\Core\View;

class AdminPage extends View
{

    public static function getAdminPage($title, $content)
    {
        return View::render('admin/page',[
            'title' => $title,
            'content' => $content
        ]);
    }

    public static function getAdminPanel($title, $content, $current)
    {
        return self::getAdminPage($title, $content);
    }

}