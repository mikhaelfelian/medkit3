<?php
class UrlHelper {
    public static function base_url($uri = '') {
        return rtrim(BASE_URL, '/') . '/' . ltrim($uri, '/');
    }
    
    public static function asset($path = '') {
        return self::base_url('assets/' . ltrim($path, '/'));
    }
    
    public static function current_url() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") 
               . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
} 