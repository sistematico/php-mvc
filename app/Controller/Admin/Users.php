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
            case 'duplicated':
                $message = 'O e-mail e/ou usuário já está sendo usado';
                $type = 'danger';
                break;
            case 'notfound':
                $message = 'ID não encontrado';
                $type = 'info';
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
            'maintitle' => 'Usuários',
            'items' => self::getUserItems($request, $pagination),
            'pagination' => AdminPage::getPagination($request, $pagination),
            'status' => self::getAlert($request)
        ]);

        return AdminPage::getAdminPanel('Usuários', $content, 'users');
    }

    public static function getNewUser($request)
    {
        $content = View::render('admin/users/form',[
            'maintitle' => 'Adicionar usuário',
            'login' => '',
            'email' => '',
            'fullname' => '',
            'status' => self::getAlert($request),
            'btnlabel' => 'Cadastrar'
        ]);

        return AdminPage::getAdminPanel('Adicionar usuário', $content, 'users');
    }

    public static function setNewUser($request)
    {
        $postVars = $request->getPostVars();
        
        $login = $postVars['login'] ?? '';
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        $userCheck = User::getUserByEmailOrLogin($email, $login);
        if ($userCheck instanceof User) {
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }
       
        $user = new User;
        $user->login = $login;
        $user->email = $email;
        $user->password = $password;
        $user->create();

        $request->getRouter()->redirect('/admin/users/' . $user->id . '/edit?status=created');
    }

    public static function getEditUser($request, $id)
    {
        $user = User::getById($id);

        if (!$user instanceof User) {
            $request->getRouter()->redirect('/admin/users');
        }

        $content = View::render('admin/users/form', [
            'maintitle' => 'Editar usuário',
            'login' => $user->login,
            'email' => $user->email,
            'fullname' => $user->fullname,
            'status' => self::getAlert($request),
            'btnlabel' => 'Atualizar'
        ]);

        return AdminPage::getAdminPanel('Editar usuário', $content, 'users');
    }

    public static function setEditUser($request, $id)
    {
        $user = User::getById($id);
        if (!$user instanceof User) {
            $request->getRouter()->redirect('/admin/users?status=notfound');
        }

        $postVars = $request->getPostVars();        
        $login = $postVars['login'] ?? '';
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        $userCheck = User::getUserByEmailOrLogin($email, $login);
        if ($userCheck instanceof User && $userCheck->id != $id) {
            $request->getRouter()->redirect('/admin/users/' . $id . '/edit?status=duplicated');
        }

        $user->login = $login;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->update();

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