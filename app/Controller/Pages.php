<?php

namespace App\Controller;

use \App\Core\View;
use \App\Model\User;

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

    public static function getAdminLogin($request, $message)
    {
        $status = !is_null($message) ? View::render('admin/status',[
            'message' => $message
        ]) : '';

        return parent::adminLogin('login', 'Login', ['status' => $status]);
    }
    
    public static function setAdminLogin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'];
        $password = $postVars['password'];

        $user = User::getUserByEmail($email);
        if (!$user instanceof User) {
            return self::getAdminLogin();
        }
    }
}