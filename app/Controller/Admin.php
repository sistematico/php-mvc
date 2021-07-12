<?php

namespace App\Controller;

use \App\Core\View;
use \App\Core\Session;
use \App\Model\User;
use \App\Model\Post;
use \App\Controller\Posts;

class Admin extends View
{

    private static $links = [
        'home'  => ['label' => 'Painel',   'link' => URL . '/admin', 'icon' => 'home'],
        'users' => ['label' => 'Usuários', 'link' => URL . '/admin/users', 'icon' => 'users'],
        'posts' => ['label' => 'Posts',    'link' => URL . '/admin/posts', 'icon' => 'file']
    ];

    private static function getPostItems($request, &$pagination)
    {
        $items = '';
        
        $total = Post::getPosts(null, null, null, 'COUNT(*) as total')->fetchObject()->total;
        
        $queryParams = $request->getQueryParams();
        $current = $queryParams['pagina'] ?? 1;

        $pagination = new \App\Core\Pagination($total, $current, 1);

        $results = Post::getPosts(null, 'id DESC', $pagination->getLimit());

        while ($row = $results->fetchObject(Post::class)) {
            $items .= parent::render('posts/post',[
                'title' => $row->title,
                'description' => $row->description,
                'picture' => $row->picture,
                'likes' => $row->likes,
                'created' => date('d/m/Y H:i:s', strtotime($row->created)),
                'updated' => date('d/m/Y H:i:s', strtotime($row->updated))
            ]);
        }

        return $items;
    }

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

    public static function getPosts($request)
    {
        $content = parent::render('admin/posts', 'Posts', [
            'items' => self::getPostItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ]);
        
        return self::getPage('Cadastrar depoimento', $content, 'posts');
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

        $contentPanel = [
            'title' => 'Painel de Admin',
            'links' => $links
        ];

        return self::getPage('admin/dashboard', $title, $contentPanel);
    }   

    private static function getPage($view, $title, $vars = [])
    {
        return parent::render('admin/main', [
            'header' => parent::render('admin/header'),
            'footer' => parent::render('admin/footer'),
            'content' => parent::render($view, $vars),
            'title' => $title
        ]);
    }
}