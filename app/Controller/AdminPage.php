<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User;
use \App\Model\Post;
use \App\Controller\Posts;

class Admin extends AdminPage
{

    private static $links = [
        'home'  => ['label' => 'Painel',   'link' => URL . '/admin', 'icon' => 'home'],
        'users' => ['label' => 'Usuários', 'link' => URL . '/admin/users', 'icon' => 'users'],
        'posts' => ['label' => 'Posts',    'link' => URL . '/admin/posts', 'icon' => 'file']
    ];

    public static function getHome($request)
    {
       $content = View::render('admin/index');
       return parent::getPanel('Painel de Admin', $content);
    }

    // Login
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