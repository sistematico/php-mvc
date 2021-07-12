<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User;
use \App\Model\Post;
use \App\Controller\Posts;

class Admin extends AdminPage
{
    public static function getHome($request)
    {
       $content = View::render('admin/page');
       return parent::getAdminPanel('Painel de Admin', $content, 'home');
    }

    public static function getLogin($request, $message = null)
    {
        $alert =  !is_null($message) ? View::render('admin/alert', ['status' => $message]) : '';
        
        return View::render('admin/login', [
            'alert' => $alert,
            'title' => 'Admin Login'
        ]);

        return View::render('admin/login', 'Login');
    }
    
    public static function setLogin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'];
        $password = $postVars['password'];

        $user = User::getUserByEmail($email);
        if (!$user instanceof User OR !password_verify($password, $user->password)) {
            return self::getLogin($request, 'E-mail ou senha inválidos.');
        }

        Session::adminLogin($user);

        $request->getRouter()->redirect('/admin');
    }

    public static function setLogout($request)
    {
        Session::adminLogout();
        $request->getRouter()->redirect('/admin/login');
    }
}