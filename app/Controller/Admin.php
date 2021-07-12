<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User;

class Admin extends View
{

    private static $links = [
        'home'  => ['label' => 'Painel',   'link' => URL . '/admin', 'icon' => 'home'],
        'users' => ['label' => 'Usuários', 'link' => URL . '/admin/users', 'icon' => 'users'],
        'posts' => ['label' => 'Posts',    'link' => URL . '/admin/posts', 'icon' => 'file']
    ];

    public static function getLogin($request, $message = null)
    {
        $alert =  !is_null($message) ? parent::render('admin/alert', ['status' => $message]) : '';
        
        return parent::render('admin/login', [
            'alert' => $alert,
            'title' => 'Admin Login'
        ]);

        return parent::render('admin/login', 'Login');
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

    public static function getPanel($title, $content, $current)
    {
        $links = '';
        foreach (self::$links as $hash => $item) {
            $links .= parent::render('admin/menu/link', [
                'label' => $item['label'],
                'link' => $item['link'],
                'icon' => $item['icon'],
                'current' => $hash == $current ? 'active' : '',
            ]);
        }
        return self::getPage($title, $content);
    }

    // // Posts
    // public static function getPosts($request)
    // {
    //     $posts = Posts::getPosts($request);
    //     return self::page('posts', 'Posts', [
    //         'items' => $posts['items'],
    //         'pagination' => $posts['pagination']
    //     ]);
    // }

    public static function getPage($title, $content)
    {
        return parent::render('admin/main', [
            'title' => $title,
            'content' => $content
        ]);
    }

    protected static function page2($view, $title, $vars = [])
    {
        return parent::render('admin/main', [
            'header' => parent::render('admin/header'),
            'footer' => parent::render('admin/footer'),
            'content' => parent::render($view, $vars),
            'title' => $title
        ]);
    }
}