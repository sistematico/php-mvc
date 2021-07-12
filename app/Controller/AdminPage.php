<?php

namespace App\Controller;

use \App\Core\View;

class AdminPage extends View
{
    private static function getAdminMenu($current)
    {
        return View::render('admin/menu/box', []);
    }

    public static function getAdminPage($title, $content)
    {
        return View::render('admin/page',[
            'title' => $title,
            'content' => $content
        ]);
    }

    public static function getAdminPanel($title, $content, $current)
    {
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getAdminMenu($current),
            'content' => $content
        ]);

        return self::getAdminPage($title, $contentPanel);
    }

}