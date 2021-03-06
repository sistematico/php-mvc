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
        
        $total = Post::read(null, null, null, 'COUNT(*) as total')->fetchObject()->total;
        
        $queryParams = $request->getQueryParams();
        $current = $queryParams['pagina'] ?? 1;

        $pagination = new Pagination($total, $current, 1);

        $results = Post::read(null, 'id DESC', $pagination->getLimit());

        while ($row = $results->fetchObject(Post::class)) {
            $items .= parent::render('posts/post',[
                'title' => $row->title,
                'description' => $row->description,
                'image' => $row->image,
                'likes' => $row->likes,
                'created' => date('d/m/Y H:i:s', strtotime($row->created)),
                'updated' => date('d/m/Y H:i:s', strtotime($row->updated))
            ]);
        }

        return $items;
    }

    public static function getPosts($request)
    {
        return parent::getPage('posts', 'Posts', [
            'items' => self::getPostItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ]);
    }

    public static function getNewPost($request)
    {
        $content = parent::render('posts/form');
        return parent::getPage('posts/form', 'Enviar post');
    }

    public static function setNewPost($request)
    {
        $postVars = $request->getPostVars();

        $post = new Post;
        $post->title = $postVars['title'];
        $post->description = $postVars['description'];
        $post->image = $postVars['image'];
        $post->create();

        $request->getRouter()->redirect('/posts/' . $post->id . '/edit');
    }

    public static function getEditPost($request, $id)
    {
        $post = Post::getById($id);

        if (!$post instanceof Post) {
            $request->getRouter()->redirect('/posts');
        }

        $content = parent::render('posts/form');
        return parent::getPage('posts/form', 'Enviar post');
    }
}