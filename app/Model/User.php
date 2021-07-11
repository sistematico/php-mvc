<?php

namespace App\Model;

use \App\Core\Database;

class User
{
    public $id;
    public $login;
    public $email;
    public $password;
    public $fullname;
    public $role;

    public static function getUserByEmail($email)
    {
        $user = (new Database('users'))->select('email = "' . $email . '"')->fetchObject(self::class);
        echo '<pre>';
        print_r($user);
        echo '</pre>';
        exit;
    }

}