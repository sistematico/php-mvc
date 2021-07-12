<?php

namespace App\Controller;

use \App\Core\View;

class AdminPage extends View
{
    private static $links = [
        'home'  => ['label' => 'Painel',   'link' => URL . '/admin', 'icon' => 'home'],
        'users' => ['label' => 'Usuários', 'link' => URL . '/admin/users', 'icon' => 'users'],
        'posts' => ['label' => 'Posts',    'link' => URL . '/admin/posts', 'icon' => 'file']
    ];

    // 3
    private static function getAdminMenu($current)
    {
        $links = '';

        foreach (self::$links as $hash => $item) {
            $links .= View::render('admin/menu/link', [
                'label' => $item['label'],
                'link' => $item['link'],
                'current' => $hash == $current ? 'active' : ''
            ]);
        }
        return View::render('admin/menu/box', [
            'links' => $links
        ]);
    }

    // 4
    public static function getAdminPage($title, $content)
    {
        return View::render('admin/page',[
            'title' => $title,
            'content' => $content,
            'header' => View::render('admin/header')
        ]);
    }

    // 2
    public static function getAdminPanel($title, $content, $current)
    {
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getAdminMenu($current),
            'content' => $content
        ]);

        return self::getAdminPage($title, $contentPanel);
    }

}