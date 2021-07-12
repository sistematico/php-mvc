<?php

namespace App\Controller\Admin;

use \App\Core\View;
use \App\Model\Post;
use \App\Core\Pagination;

class Posts extends Page
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

    public static function getPosts($request)
    {
        $content = View::render('admin/posts/index', [
            'items' => self::getPostItems($request, $pagination)
        ]);

        return parent::getAdminPanel('Posts', $content, 'posts');
    }

    public static function getNewPost($request)
    {
        $content = View::render('admin/posts/form');
        return parent::getAdminPanel('Cadastrar Post', $content, 'posts');
    }

    public static function setNewPost($request)
    {
        $postVars = $request->getPostVars();
        
        $post = new Post;
        $post->title = $postVars['title'] ?? '';
        $post->description = $postVars['description'] ?? '';
        $post->picture = $postVars['picture'] ?? '';
        $post->likes = 0;
        $post->create();

        $request->getRouter()->redirect('/admin/posts/' . $post->id . '/edit?status=created');
    }

    public static function getEditPost($request, $id)
    {
        $post = Post::getPostById($id);

        $content = View::render('admin/posts/form', [
            'title' => $post->title,
            'description' => $post->description
        ]);

        return parent::getAdminPanel('Editar Post', $content, 'posts');
    }
}