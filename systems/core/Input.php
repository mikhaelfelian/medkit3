<?php
class Input {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function post($key = null, $default = null) {
        if ($key === null) {
            return InputSanitizer::sanitize($_POST);
        }
        return InputSanitizer::sanitize($_POST[$key] ?? $default);
    }
    
    public function get($key = null, $default = null) {
        if ($key === null) {
            return InputSanitizer::sanitize($_GET);
        }
        return InputSanitizer::sanitize($_GET[$key] ?? $default);
    }
} 