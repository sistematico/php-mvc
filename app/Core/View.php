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

    protected static function page($view, $title, $vars = [])
    {
        return View::render('main', [
            'header' => self::render('header'),
            'footer' => self::render('footer'),
            'content' => self::render($view, $vars),
            'title' => $title
        ]);
    }

    protected static function pageAdmin($view, $title, $vars = [])
    {
        return View::render('admin/main', [
            'header' => self::render('admin/header'),
            'footer' => self::render('admin/footer'),
            'content' => self::render($view, $vars),
            'title' => $title
        ]);
    }

    public static function getPagination($request, $pagination)
    {
        $pages = $pagination->getPages();
        if (count($pages) <= 1) return '';
        $links = '';
        $url = $request->getRouter()->getCurrentUrl();
    }
}