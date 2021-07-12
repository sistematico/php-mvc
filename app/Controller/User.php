<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User as EntityUser;

class User extends View
{
    public static function getUserLogin($request, $message = null)
    {
        $alert =  !is_null($message) ? parent::render('admin/alert', ['status' => $message]) : '';

        return parent::render('login', [
            'alert' => $alert,
            'title' => 'Login do Usuário'
        ]);
    }
    
    public static function setUserLogin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'];
        $password = $postVars['password'];

        $user = EntityUser::getUserByEmail($email);
        if (!$user instanceof EntityUser OR !password_verify($password, $user->password)) {
            return self::getUserLogin($request, 'E-mail ou senha inválidos.');
        }

        Session::UserLogin($user);
        $request->getRouter()->redirect('/');
    }

    public static function setUserLogout($request)
    {
        Session::UserLogout();

        $request->getRouter()->redirect('/users/login');
    }
}