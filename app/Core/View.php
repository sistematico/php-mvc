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
        return self::render('main', [
            'header' => self::render('header'),
            'footer' => self::render('footer'),
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
        $queryParams = $request->getQueryParams();

        foreach ($pages as $page) {
            $queryParams['pagina'] = $page['page'];
            $link = $url . '?' . http_build_query($queryParams);

            $links .= self::render('pagination/link', [
                'page' => $page['page'],
                'link' => $link
            ]);
        }

        return self::render('pagination/box', ['links' => $links]);
    }

    public static function getPaginationRaw($request, $pagination)
    {
        $pages = $pagination->getPages();

        if (count($pages) <= 1) return '';
        
        $links = [];

        $url = $request->getRouter()->getCurrentUrl();
        $queryParams = $request->getQueryParams();

        foreach ($pages as $page) {
            $queryParams['pagina'] = $page['page'];
            $link = $url . '?' . http_build_query($queryParams);

            $links[] = [
                'page' => $page['page'],
                'link' => $link
            ];
        }

        return $links;
    }
}