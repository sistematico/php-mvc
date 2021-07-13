<?php

namespace App\Model;

use App\Core\Database;

class User
{
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
            'author_id' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'likes' => 0
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
            'author_id' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
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
}