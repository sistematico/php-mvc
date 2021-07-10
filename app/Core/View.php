<?php

namespace App\Core;

class View
{
    private static function content($view)
    {
        $file = __DIR__ . '/../view/{$view}.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    public static function render($view, $vars = [])
    {
        return self::content($view);
    }
}