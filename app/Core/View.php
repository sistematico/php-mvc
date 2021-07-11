<?php

namespace App\Core;

class View
{
    private static function content($view)
    {
        $file = dirname(__DIR__) . "/view/{$view}.html";
        return file_exists($file) ? file_get_contents($file) : '';
    }

    protected static function render($view, $vars = [])
    {
        $keys = array_map(function($item){
            return '{{' . $item . '}}'; 
        },array_keys($vars));

        return str_replace($keys, array_values($vars),self::content($view));
    }

    protected static function main($view, $title, $vars = [])
    {
        return View::render('main', [
            'title' => $title,
            'content' => self::render($view, $vars)
        ]);
    }
}