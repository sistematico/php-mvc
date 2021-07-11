<?php

namespace App\Core;

class View
{
    private static $vars = [];

    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

    private static function content($view)
    {
        $file = dirname(__DIR__) . "/view/{$view}.html";

        echo '<pre>';
        print_r($file);
        echo '</pre>';
        exit;

        return file_exists($file) ? file_get_contents($file) : '';
    }

    protected static function render($view, $vars = [])
    {
        $vars = array_merge(self::$vars, $vars);

        $keys = array_map(function($item){
            return '{{' . $item . '}}'; 
        },array_keys($vars));

        return str_replace($keys, array_values($vars),self::content($view));
    }

    protected static function page($dir, $view, $title, $vars = [])
    {
        return View::render($dir . '/' . $view, [
            'header' => self::render($dir . '/header'),
            'footer' => self::render($dir . '/footer'),
            'title' => $title,
            'content' => self::render($dir . '/' . $view, $vars)
        ]);
    }
}