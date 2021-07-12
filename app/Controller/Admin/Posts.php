<?php

namespace App\Controller\Admin;

// use \App\Controller\Admin\Page;
use \App\Core\View;

class Posts extends Page
{

    public static function getPosts($request)
    {
        $content = View::render('admin/posts/index', []);
        return parent::getAdminPanel('Posts', $content, 'posts');
    }

}