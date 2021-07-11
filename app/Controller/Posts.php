<?php

namespace App\Controller;

use \App\Model\Post;
use \App\Core\View;

class Posts extends View
{
    private static function getPostItems()
    {
        $items = '';

        $results = Post::getPosts();

        return $items;
    }

    public static function getPosts()
    {
        //return Post::getPosts(null, 'id DESC');
        return parent::page('posts', 'Posts', [
            'items' => self::getPostItems()
        ]);
    }

    public static function getPost($request)
    {
        return parent::page('posts/new', 'Enviar post');
    }

    public static function insertPost($request)
    {
        $postVars = $request->getPostVars();

        $post = new Post;
        $post->title = $postVars['title'];
        $post->description = $postVars['description'];
        $post->picture = $postVars['picture'];
        $post->create();

        return self::getPosts();
    }
}