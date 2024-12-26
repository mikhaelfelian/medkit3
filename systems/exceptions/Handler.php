<?php

class Handler
{
    public static function render($exception)
    {
        $message = $exception->getMessage() ?: 'An error occurred';
        $code = $exception->getCode() ?: 500;
        
        require_once __DIR__ . '/../../app/views/errors/exception.php';
        exit;
    }
} 