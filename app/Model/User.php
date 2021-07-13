<?php

namespace App\Model;

use App\Core\Database;

class User
{
    // id       INTEGER primary key,
    // login    TEXT,
    // email    TEXT,
    // password TEXT,
    // fullname TEXT,
    // avatar   TEXT,
    // role     TEXT default 'user',
    // created  REAL default CURRENT_TIMESTAMP,
    // access   TEXT,
    // gender   text,
    // bio      text,
    // verified text default 'N',
    // plan     text default 'basic',
    // valid    text default CURRENT_TIMESTAMP

    public $id;
    public $login;
    public $email;
    public $password;
    public $fullname;
    public $role;

    public function create()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $this->id = (new Database('users'))->insert([
            'login' => $this->login,
            'email' => $this->email,
            'password' => $this->password,
            'fullname' => $this->fullname
        ]);

        return true;
    }

    public static function read($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('users'))->select($where, $order, $limit, $fields);
    }

    public function update()
    {
        date_default_timezone_set('America/Sao_Paulo');

        return (new Database('users'))->update('id = ' . $this->id,[
            'login' => $this->login,
            'email' => $this->email,
            'password' => $this->password,
            'fullname' => $this->fullname,
            'updated' => date('Y-m-d H:i:s', time())
        ]);
    }

    public function delete()
    {
        return (new Database('users'))->delete('id = ' . $this->id);
    }

    public static function getById($id)
    {
        return self::read('id = ' . $id)->fetchObject(self::class);
    }

    public static function getUserByEmail($email)
    {
        return (new Database('users'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
    
    public static function getUserByEmailOrLogin($email, $login)
    {
        return (new Database('users'))->select('email = "' . $email . '" OR login = "' . $login . '"')->fetchObject(self::class);
    }
}