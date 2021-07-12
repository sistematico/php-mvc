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

    public static function getAdminPage($title, $content)
    {
        return View::render('admin/page',[
            'title' => $title,
            'content' => $content,
            'header' => View::render('admin/header'),
            'footer' => View::render('admin/footer')
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

    public static function getPagination($request, $pagination)
    {
        $pages = $pagination->getPages();

        if (count($pages) <= 1) return '';
        
        $links = '';
        $url = $request->getRouter()->getCurrentUrl();
        $queryParams = $request->getQueryParams();

        foreach ($pages as $page) {
            $queryParams['pagina'] = $page['page'];
            $link = $url . '?' . http_build_query($queryParams);

            $links .= self::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link
            ]);
        }

        return self::render('admin/pagination/box', ['links' => $links]);
    }
}