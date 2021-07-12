<?php

namespace App\Controller;

use \App\Core\View;
use \App\Model\User;
use \App\Core\Session;

class Pages extends View
{
    public static function home()
    {
        return parent::getPage('posts', 'Home', [
            'title' => 'PHP MVC'
        ]);
    }

    public static function error($code)
    {
        switch ($code) {
            case 404:
                $title = 'Página não encontrada';
                break;                
            case 405:
                $title = 'Método não permitido';
                break;                
            default:
                $title = '';
                break;
        }

        $error = 'Erro ' . $code;
        
        return parent::getPage('error', $title, ['error' => $error]);
    }
}