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
            $items .= AdminPage::render('admin/users/item',[
                'id' => $row->id,
                'login' => $row->login,
                'fullname' => $row->fullname,
                'email' => $row->email,
                'avatar' => $row->avatar,
                'created' => date('d/m/Y H:i:s', strtotime($row->created))
            ]);
        }

        return $items;
    }

    public static function getUsers($request)
    {
        $content = View::render('admin/users/index', [
            'maintitle' => 'Posts',
            'items' => self::getUserItems($request, $pagination),
            'pagination' => AdminPage::getPagination($request, $pagination),
            'status' => self::getAlert($request)
        ]);

        return AdminPage::getAdminPanel('Posts', $content, 'posts');
    }

    public static function getNewUser($request)
    {
        $content = View::render('admin/users/form',[
            'maintitle' => 'Adicionar usuário',
            'login' => '',
            'fullname' => '',
            'status' => '',
            'btnlabel' => 'Cadastrar'
        ]);

        return AdminPage::getAdminPanel('Adicionar usuário', $content, 'posts');
    }

    public static function setNewUser($request)
    {
        $postVars = $request->getPostVars();
        
        $post = new User;
        $post->title = $postVars['login'] ?? '';
        $post->description = $postVars['fullname'] ?? '';
        $post->image = $postVars['image'] ?? '';
        $post->likes = 0;
        $post->create();

        $request->getRouter()->redirect('/admin/users/' . $post->id . '/edit?status=created');
    }

    public static function getEditUser($request, $id)
    {
        $post = User::getById($id);

        if (!$post instanceof User) {
            $request->getRouter()->redirect('/admin/users');
        }

        $content = View::render('admin/users/form', [
            'maintitle' => 'Editar usuário',
            'login' => $post->login,
            'fullname' => $post->fullname,
            'status' => self::getAlert($request)
        ]);

        return AdminPage::getAdminPanel('Editar usuário', $content, 'users');
    }

    public static function setEditUser($request, $id)
    {
        $post = User::getById($id);

        if (!$post instanceof User) {
            $request->getRouter()->redirect('/admin/users');
        }

        $postVars = $request->getPostVars();

        $post->login = $postVars['login'] ?? $post->title;
        $post->fullname = $postVars['fullname'] ?? $post->description;
        $post->image = $postVars['image'] ?? $post->image;
        $post->update();

        $request->getRouter()->redirect('/admin/users/' . $id . '/edit?status=updated');
    }

    public static function getDeleteUser($request, $id)
    {
        $post = User::getById($id);

        if (!$post instanceof User) {
            $request->getRouter()->redirect('/admin/users');
        }

        $content = View::render('admin/users/delete', [
            'maintitle' => 'Excluir post',
            'login' => $post->login
        ]);

        return AdminPage::getAdminPanel('Excluir usuário', $content, 'users');
    }

    public static function setDeleteUser($request, $id)
    {
        $post = User::getById($id);

        if (!$post instanceof User) {
            $request->getRouter()->redirect('/admin/users');
        }

        $post->delete();

        $request->getRouter()->redirect('/admin/users?status=deleted');
    }
}