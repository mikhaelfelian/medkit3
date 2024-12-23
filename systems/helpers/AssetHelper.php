<?php
class AssetHelper {
    private static $instance = null;
    
    private function __construct() {}
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function theme($path) {
        return BaseRouting::asset('theme/admin-lte-3/' . ltrim($path, '/'));
    }
    
    public static function custom($path) {
        return BaseRouting::asset(ltrim($path, '/'));
    }
    
    public static function exists($path) {
        return file_exists(ROOT_PATH . '/public/assets/' . ltrim($path, '/'));
    }
    
    public static function logo() {
        $settings = Settings::getInstance();
        
        // Check if custom logo exists
        if (!empty($settings->logo) && self::exists('images/' . $settings->logo)) {
            return self::custom('images/' . $settings->logo);
        }
        
        // Return default AdminLTE logo
        return self::theme('dist/img/AdminLTELogo.png');
    }
}
?> 