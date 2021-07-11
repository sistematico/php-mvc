<?php

namespace App\Core;

class View
{
    private static $vars = [];

    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

    private static function content($dir, $view)
    {
        $file = dirname(__DIR__) . "/view/{$dir}/{$view}.html";
        return file_exists($file) ? file_get_contents($file) : '';
    }

    protected static function render($dir, $view, $vars = [])
    {
        $vars = array_merge(self::$vars, $vars);

        $keys = array_map(function($item){
            return '{{' . $item . '}}'; 
        },array_keys($vars));

        return str_replace($keys, array_values($vars),self::content($dir, $view));
    }

    protected static function page($dir, $view, $title, $vars = [])
    {
        return View::render('main', [
            'header' => self::render('header'),
            'footer' => self::render('footer'),
            'title' => $title,
            'content' => self::render($view, $vars)
        ]);
    }
}