<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User as EntityUser;

class User extends View
{
    public static function getAdmin()
    {
        return parent::pageAdmin('admin/dashboard', 'Painel de Admin');
    }

    public static function getAdminLogin($request, $message = null)
    {
        $status = !is_null($message) ? $message : '';
        return parent::adminLogin('admin/login', 'Login', ['status' => $status]);
    }
    
    public static function setAdminLogin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'];
        $password = $postVars['password'];

        $user = EntityUser::getUserByEmail($email);
        if (!$user instanceof EntityUser OR !password_verify($password, $user->password)) {
            return self::getAdminLogin($request, 'E-mail ou senha inválidos.');
        }

        Session::adminLogin($user);

        $request->getRouter()->redirect('/admin');
    }

    public static function setAdminLogout($request)
    {
        Session::adminLogout();

        $request->getRouter()->redirect('/admin/login');
    }
}