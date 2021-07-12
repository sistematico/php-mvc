<?php

namespace App\Core;

class Session
{

    private static function init()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function adminLogin($user)
    {
        self::init();
        $_SESSION['admin']['user'] = [
            'id'       => $user->id,
            'login'    => $user->login,
            'email'    => $user->email,
            'fullname' => $user->fullname,
        ];
        return true;
    }

    public static function adminLogout()
    {
        self::init();
        unset($_SESSION['admin']['user']);
        return true;
    }

    public static function adminIsLogged()
    {
        self::init();
        return isset($_SESSION['admin']['user']['id']);
    }

    public static function userLogin($user)
    {
        self::init();

        $_SESSION['user'] = [
            'id'       => $user->id,
            'login'    => $user->login,
            'email'    => $user->email,
            'fullname' => $user->fullname,
        ];
        return true;
    }

    public static function userLogout()
    {
        self::init();
        unset($_SESSION['user']);
        return true;
    }

    public static function userIsLogged()
    {
        self::init();
        return isset($_SESSION['user']['id']);
    }
}