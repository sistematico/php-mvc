<?php

namespace App\Model;

use App\Core\Database;

class Post
{
    public $id;
    public $name;
    public $description;
    public $picture;
    public $date;

    public function create()
    {
        $this->id = (new Database('posts'))->insert([
            'title' => $this->title,
            'description' => $this->description,
            'picture' => $this->picture
        ]);

        return true;
    }
}