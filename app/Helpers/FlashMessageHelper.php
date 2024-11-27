<?php

namespace App\Helpers;

class FlashMessageHelper
{
    public static function flashError($message)
    {
        flash(
            message: $message,
            type: 'error',
            options: [
                'position' => 'top-center',
                'timeout' => 3000, // Uncomment if needed
            ]
        );
    }

    public static function flashWarning($message)
    {
        flash(
            message: $message,
            type: 'warning',
            options: [
                'position' => 'top-center',
            ]
        );
    }

    public static function flashSuccess($message)
    {
        flash(
            message: $message,
            type: 'success',
            options: [
                'position' => 'top-center',
                'timeout' => 1000,
            ]
        );
    }

    public static function flashInfo($message)
    {
        flash(
            message: $message,
            type: 'info',
            options: [
                'position' => 'top-center'
            ]
        );
    }
}
