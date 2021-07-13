<?php

namespace App\Core;

use \App\Core\View;

class Alert extends View
{
    public static function getSuccess($message) {
        return View::render('admin/alert/status', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public static function getError($message) {
        return View::render('admin/alert/status', [
            'type' => 'danger',
            'message' => $message
        ]);
    }
}