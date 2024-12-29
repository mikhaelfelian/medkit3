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
        return BaseRouting::url('public/assets/theme/admin-lte-3/' . ltrim($path, '/'));
    }
    
    public static function file($path) {
        return BASE_URL . '/public/file/' . ltrim($path, '/');
    }
    
    public static function exists($path) {
        return file_exists(ROOT_PATH . '/public/assets/' . ltrim($path, '/'));
    }
    
    public static function logo() {
        $settings = Settings::getInstance();
        
        // Check if custom logo exists
        if (!empty($settings->logo)) {
            return BASE_URL . '/public/file/app/' . $settings->logo;
        }
        
        // Return default AdminLTE logo
        return self::theme('dist/img/AdminLTELogo.png');
    }
}
?> 