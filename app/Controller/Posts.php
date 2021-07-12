<?php

namespace App\Controller;

use \App\Model\Post;
use \App\Core\View;
use \App\Core\Pagination;

class Posts extends View
{
    private static function getPostItems($request, &$pagination)
    {
        $items = '';
        
        $total = Post::getPosts(null, null, null, 'COUNT(*) as total')->fetchObject()->total;
        
        $queryParams = $request->getQueryParams();
        $current = $queryParams['pagina'] ?? 1;

        $pagination = new Pagination($total, $current, 1);

        $results = Post::getPosts(null, 'id DESC', $pagination->getLimit());

        while ($row = $results->fetchObject(Post::class)) {
            $items .= parent::render('posts/post',[
                'title' => $row->title,
                'description' => $row->description,
                'date' => $row->created,
                'likes' => $row->likes
            ]);
        }

        return $items;
    }

    public static function getPosts($request)
    {
        return [
            'items' => self::getPostItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ];
    }

    public static function renderPosts($request)
    {
        return parent::page('posts', 'Posts', [
            'items' => self::getPostItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ]);
    }

    public static function getPost($request)
    {
        return parent::page('posts/new', 'Enviar post');
    }

    public static function setPost($request)
    {
        $postVars = $request->getPostVars();

        $post = new Post;
        $post->title = $postVars['title'];
        $post->description = $postVars['description'];
        $post->picture = $postVars['picture'];
        $post->create();

        return self::getPosts($request);
    }
}