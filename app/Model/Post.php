<?php

namespace App\Model;

use App\Core\Database;

class Post
{
    public $id;
    public $author;
    public $title;
    public $description;
    public $picture;
    public $likes;
    public $date;

    public function create()
    {
        $this->id = (new Database('posts'))->insert([
            'author_id' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'picture' => $this->picture,
            'likes' => 0
        ]);

        return true;
    }

    public static function getPostById($id)
    {
        return self::getPosts('id = ' . $id)->fetchObject(self::class);
    }

    public static function getPosts($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('posts'))->select($where, $order, $limit, $fields);
    }
}