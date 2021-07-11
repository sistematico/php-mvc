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
}