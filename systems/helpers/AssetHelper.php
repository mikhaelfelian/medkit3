<?php
class AssetHelper {
    private static $instance = null;
    
    private function __construct() {
        // Private constructor
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Generate URL for assets
     */
    public static function url($path) {
        // Remove leading slash if exists
        $path = ltrim($path, '/');
        // Fix directory separators for Windows
        $path = str_replace('\\', '/', $path);
        return BASE_URL . '/public/assets/' . $path;
    }
    
    /**
     * Generate theme asset URL
     */
    public static function theme($path) {
        return self::url('theme/admin-lte-3/' . ltrim($path, '/'));
    }
    
    /**
     * Generate URL for custom assets
     */
    public static function custom($path) {
        return self::url('custom/' . ltrim($path, '/'));
    }
    
    /**
     * Check if asset file exists
     */
    public static function exists($path) {
        $fullPath = self::getFullPath($path);
        return file_exists($fullPath) && is_readable($fullPath);
    }
    
    /**
     * Get full server path for asset
     */
    public static function getFullPath($path) {
        // Fix directory separators for Windows
        $path = str_replace('/', DIRECTORY_SEPARATOR, ltrim($path, '/'));
        return ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $path;
    }
}
?> 