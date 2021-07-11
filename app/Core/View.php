<?php

namespace App\Core;

class View
{
    private static function content($view)
    {
        $file = dirname(__DIR__) . "/view/{$view}.html";
        return file_exists($file) ? file_get_contents($file) : '';
    }

    public static function render($view, $vars = [])
    {
        $content = self::content($view);
        return $content;
    }
}