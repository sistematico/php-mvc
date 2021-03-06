<?php

namespace App\Model;

use App\Core\Database;

class Post
{
    public $id;
    public $author;
    public $title;
    public $description;
    public $image;
    public $likes;
    public $date;

    public function create()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $this->id = (new Database('posts'))->insert([
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
        return (new Database('posts'))->select($where, $order, $limit, $fields);
    }

    public function update()
    {
        date_default_timezone_set('America/Sao_Paulo');

        return (new Database('posts'))->update('id = ' . $this->id,[
            'author_id' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'updated' => date('Y-m-d H:i:s', time())
        ]);
    }

    public function delete()
    {
        return (new Database('posts'))->delete('id = ' . $this->id);
    }

    public static function getById($id)
    {
        return self::read('id = ' . $id)->fetchObject(self::class);
    }
}