<?php

namespace App\Controller;

use \App\Core\View;
use \App\Model\User;
use \App\Core\Session;

class Pages extends View
{
    public static function home()
    {
        return parent::page('posts', 'Home', [
            'name' => 'PHP2 MVC'
        ]);
    }

    public static function posts()
    {
        return parent::page('posts', 'Posts', [
            'name' => 'PHP2 MVC'
        ]);
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

        $user = User::getUserByEmail($email);
        if (!$user instanceof User OR !password_verify($password, $user->password)) {
            return self::getAdminLogin($request, 'E-mail ou senha inválidos.');
        }

        Session::adminLogin($user);
    }
}