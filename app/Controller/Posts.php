<?php

namespace App\Controller;

use \App\Core\View;

class Posts extends View
{
    public static function getPosts()
    {
        return parent::page('posts', 'Posts');
    }

    public static function posts()
    {
        return parent::page('posts', 'Posts', [
            'name' => 'PHP2 MVC'
        ]);
    }
}