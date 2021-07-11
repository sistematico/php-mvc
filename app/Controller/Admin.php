<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User as EntityUser;

class Admin extends View
{
    public static function getAdmin()
    {
        return parent::pageAdmin('admin/dashboard', 'Painel de Admin');
    }

    public static function getAdminLogin($request, $message = null)
    {
        $alert =  !is_null($message) ? parent::render('admin/alert', ['status' => $message]) : '';
        
        return parent::render('admin/login', [
            'alert' => $alert,
            'title' => 'Admin Login'
        ]);

        return parent::render('admin/login', 'Login');
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