<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User as EntityUser;

class Admin extends View
{

    private static $links = [
        'home'  => ['label' => 'Painel',   'link' => URL . '/admin'],
        'users' => ['label' => 'Usuários', 'link' => URL . '/admin/users'],
        'posts' => ['label' => 'Posts',    'link' => URL . '/admin/posts']
    ];

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

    private static function getAdminMenu($current)
    {
        $links = '';

        foreach (self::$links as $hash => $item) {
            $links .= parent::render('admin/menu/link', [
                'label' => $item['label'],
                'link' => $item['link'],
                'current' => $hash == $current ? 'active' : '',
            ]);
        }

        return parent::render('admin/menu/sidebar', [
            'links' => $links
        ]);
    }

    public static function getAdminPanel($title, $content, $current)
    {       
        // $contentPanel = parent::render('admin/sidebar', [
        //     'menu' => self::getAdminMenu($current)
        // ]);

        //return parent::pageAdmin('admin/dashboard', 'Painel de Admin', $contentPanel);

        return parent::render('admin/main', [
            'header' => self::render('admin/header'),
            'sidebar' => self::render('admin/sidebar', ['menu' => self::getAdminMenu($current)]),
            'footer' => self::render('admin/footer'),
            'content' => self::render('admin/dashboard'),
            'title' => $title
        ]);
    }
}