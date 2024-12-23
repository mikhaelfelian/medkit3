<?php
class Notification {
    protected static $instance = null;
    
    private function __construct() {
        // Private constructor to prevent direct creation
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Success notification
     */
    public static function success($message) {
        BaseNotification::getInstance()->success($message);
    }
    
    /**
     * Error notification
     */
    public static function error($message) {
        BaseNotification::getInstance()->error($message);
    }
    
    /**
     * Warning notification
     */
    public static function warning($message) {
        BaseNotification::getInstance()->warning($message);
    }
    
    /**
     * Info notification
     */
    public static function info($message) {
        BaseNotification::getInstance()->info($message);
    }
    
    /**
     * Render all notifications
     */
    public static function render() {
        return BaseNotification::getInstance()->render();
    }
    
    /**
     * Check if has notifications
     */
    public static function has() {
        return BaseNotification::getInstance()->has();
    }
    
    /**
     * Clear all notifications
     */
    public static function clear() {
        BaseNotification::getInstance()->clear();
    }
}
?> 