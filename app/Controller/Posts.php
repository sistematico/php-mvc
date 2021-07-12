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
                'picture' => $row->picture,
                'likes' => $row->likes,
                'created' => date('d/m/Y H:i:s', strtotime($row->created)),
                'updated' => date('d/m/Y H:i:s', strtotime($row->updated))
            ]);
        }

        return $items;
    }

    private static function getPostItemsRaw($request, &$pagination)
    {
        $items = [];
        
        $total = Post::getPosts(null, null, null, 'COUNT(*) as total')->fetchObject()->total;
        
        $queryParams = $request->getQueryParams();
        $current = $queryParams['pagina'] ?? 1;

        $pagination = new Pagination($total, $current, 1);

        $results = Post::getPosts(null, 'id DESC', $pagination->getLimit());

        while ($row = $results->fetchObject(Post::class)) {
            $items[] = [
                'title' => $row->title,
                'description' => $row->description,
                'picture' => $row->picture,
                'likes' => $row->likes,
                'created' => date('d/m/Y H:i:s', strtotime($row->created)),
                'updated' => date('d/m/Y H:i:s', strtotime($row->updated))
            ];
        }

        return $items;
    }

    public static function getPosts($request)
    {
        return parent::page('posts', 'Posts', [
            'items' => self::getPostItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ]);
    }

    public static function getPostsRaw($request)
    {
        return [
            'items' => self::getPostItemsRaw($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ];
    }


    public static function getNewPost($request)
    {
        $content = parent::render('posts/form');
        return parent::page('posts/form', 'Enviar post');
    }

    public static function setNewPost2($request)
    {
        $postVars = $request->getPostVars();

        $post = new Post;
        $post->title = $postVars['title'];
        $post->description = $postVars['description'];
        $post->picture = $postVars['picture'];
        $post->create();

        return self::getPosts($request);
    }

    public static function setNewPost($request)
    {
        $postVars = $request->getPostVars();

        $post = new Post;
        $post->title = $postVars['title'];
        $post->description = $postVars['description'];
        $post->picture = $postVars['picture'];
        $post->create();

        $request->getRouter()->redirect('/posts/' . $post->id . '/edit');
    }
}