<?php

namespace App\Controller\Admin;

use \App\Core\View;
use \App\Model\User;
use \App\Core\Pagination;
use \App\Controller\Admin\Page as AdminPage;

class Users extends AdminPage
{
    public static function getAlert($request, $view = 'admin/components/alert') {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status'])) return '';
        
        switch ($queryParams['status']) {
            case 'created':
                $message = 'Usuário criado com sucesso';
                $type = 'success';
                break;
            case 'updated':
                $message = 'Usuário editado com sucesso';
                $type = 'success';
                break;
            case 'deleted':
                $message = 'Usuário excluído com sucesso';
                $type = 'success';
                break;
            default:
                $message = 'Retorno não identificado.';
                $type = 'warning';
                break;
        }

        return View::render($view, ['type' => $type,'message' => $message]);
    }

    private static function getUserItems($request, &$pagination)
    {
        $items = '';
        
        $total = User::read(null, null, null, 'COUNT(*) as total')->fetchObject()->total;
        
        $queryParams = $request->getQueryParams();
        $current = $queryParams['pagina'] ?? 1;

        $pagination = new Pagination($total, $current, 2);

        $results = User::read(null, 'id DESC', $pagination->getLimit());

        while ($row = $results->fetchObject(User::class)) {
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

    public static function getUsers($request)
    {
        $content = View::render('admin/posts/index', [
            'maintitle' => 'Posts',
            'items' => self::getUserItems($request, $pagination),
            'pagination' => AdminPage::getPagination($request, $pagination),
            'status' => self::getAlert($request)
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
        
        $post = new User;
        $post->title = $postVars['title'] ?? '';
        $post->description = $postVars['description'] ?? '';
        $post->image = $postVars['image'] ?? '';
        $post->likes = 0;
        $post->create();

        $request->getRouter()->redirect('/admin/posts/' . $post->id . '/edit?status=created');
    }

    public static function getEditPost($request, $id)
    {
        $post = User::getById($id);

        if (!$post instanceof User) {
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
        $post = User::getById($id);

        if (!$post instanceof User) {
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
        $post = User::getById($id);

        if (!$post instanceof User) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $content = View::render('admin/posts/delete', [
            'maintitle' => 'Excluir post',
            'title' => $post->title
        ]);

        return AdminPage::getAdminPanel('Excluir Post', $content, 'posts');
    }

    public static function setDeletePost($request, $id)
    {
        $post = User::getById($id);

        if (!$post instanceof User) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $post->delete();

        $request->getRouter()->redirect('/admin/posts?status=deleted');
    }
}