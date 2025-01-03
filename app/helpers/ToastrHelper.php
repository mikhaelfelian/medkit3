<?php
class ToastrHelper {
    protected static $sessionKey = 'toastr_notifications';
    
    public static function success($message, $title = '') {
        self::add('success', $message, $title);
    }
    
    public static function error($message, $title = '') {
        self::add('error', $message, $title);
    }
    
    public static function warning($message, $title = '') {
        self::add('warning', $message, $title);
    }
    
    public static function info($message, $title = '') {
        self::add('info', $message, $title);
    }
    
    protected static function add($type, $message, $title = '') {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize flash data if not set
        if (!isset($_SESSION[self::$sessionKey])) {
            $_SESSION[self::$sessionKey] = [];
        }
        
        // Add notification
        $_SESSION[self::$sessionKey][] = [
            'type' => $type,
            'message' => $message,
            'title' => $title
        ];
    }
    
    public static function get() {
        if (!isset($_SESSION[self::$sessionKey])) {
            return [];
        }

        $notifications = $_SESSION[self::$sessionKey];
        unset($_SESSION[self::$sessionKey]);
        
        return $notifications;
    }
    
    public static function has() {
        return isset($_SESSION[self::$sessionKey]) && !empty($_SESSION[self::$sessionKey]);
    }
    
    public static function clear() {
        unset($_SESSION[self::$sessionKey]);
    }
} 