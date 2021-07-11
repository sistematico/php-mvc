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
        echo '<pre>';
        print_r($this);
        echo '</pre>';
        exit;
        return (new Database('users'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

}