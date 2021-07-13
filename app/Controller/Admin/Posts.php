<?php

namespace App\Controller\Admin;

use \App\Core\View;
use \App\Model\Post;
use \App\Controller\Admin\Page as AdminPage;
use \App\Core\Pagination;

class Posts extends AdminPage
{
    public static function getAlert($request, $view = 'admin/components/alert') {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status'])) return '';
        
        switch ($queryParams['status']) {
            case 'created':
                $message = 'Post criado com sucesso';
                $type = 'success';
                break;
            case 'updated':
                $message = 'Post editado com sucesso';
                $type = 'success';
                break;
            default:
                $message = 'Retorno não identificado.';
                $type = 'warning';
                break;
        }

        return View::render($view, ['type' => $type,'message' => $message]);
    }

    private static function getPostItems($request, &$pagination)
    {
        $items = '';
        
        $total = Post::getPosts(null, null, null, 'COUNT(*) as total')->fetchObject()->total;
        
        $queryParams = $request->getQueryParams();
        $current = $queryParams['pagina'] ?? 1;

        $pagination = new Pagination($total, $current, 2);

        $results = Post::getPosts(null, 'id DESC', $pagination->getLimit());

        while ($row = $results->fetchObject(Post::class)) {
            $items .= AdminPage::render('admin/posts/item',[
                'id' => $row->id,
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
        $content = View::render('admin/posts/index', [
            'maintitle' => 'Posts',
            'items' => self::getPostItems($request, $pagination),
            'pagination' => AdminPage::getPagination($request, $pagination)
        ]);

        return AdminPage::getAdminPanel('Posts', $content, 'posts');
    }

    public static function getNewPost($request)
    {
        $content = View::render('admin/posts/form',[
            'maintitle' => 'Novo post',
            'title' => '',
            'description' => '',
            'status' => ''
        ]);

        return AdminPage::getAdminPanel('Cadastrar Post', $content, 'posts');
    }

    public static function setNewPost($request)
    {
        $postVars = $request->getPostVars();
        
        $post = new Post;
        $post->title = $postVars['title'] ?? '';
        $post->description = $postVars['description'] ?? '';
        $post->image = $postVars['image'] ?? '';
        $post->likes = 0;
        $post->create();

        $request->getRouter()->redirect('/admin/posts/' . $post->id . '/edit?status=created');
    }

    public static function getEditPost($request, $id)
    {
        $post = Post::getPostById($id);

        if (!$post instanceof Post) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $content = View::render('admin/posts/form', [
            'maintitle' => 'Editar post',
            'title' => $post->title,
            'description' => $post->description,
            'status' => self::getAlert($request)
        ]);

        return AdminPage::getAdminPanel('Editar Post', $content, 'posts');
    }

    public static function setEditPost($request, $id)
    {
        $post = Post::getPostById($id);

        if (!$post instanceof Post) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $postVars = $request->getPostVars();

        $post->title = $postVars['title'] ?? $post->title;
        $post->description = $postVars['description'] ?? $post->description;
        $post->image = $postVars['image'] ?? $post->image;
        $post->update();

        $request->getRouter()->redirect('/admin/posts/' . $id . '/edit?status=updated');
    }

    public static function getDeletePost($request, $id)
    {
        $post = Post::getPostById($id);

        if (!$post instanceof Post) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $content = View::render('admin/posts/delete', [
            'maintitle' => 'Excluir post',
            'title' => $post->title
        ]);

        return AdminPage::getAdminPanel('Excluir Post', $content, 'posts');
    }
}