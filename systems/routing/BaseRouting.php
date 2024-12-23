<?php
class BaseRouting {
    protected static $routes = [];
    protected static $notFoundCallback;
    protected static $baseUrl;
    protected static $defaultController = 'Dashboard';
    protected static $defaultMethod = 'index';
    
    public static function init($baseUrl) {
        self::$baseUrl = $baseUrl;
    }
    
    public static function dispatch() {
        try {
            // Get the current URI
            $uri = $_SERVER['REQUEST_URI'];
            
            // Remove base URL from URI
            $baseUrl = parse_url(self::$baseUrl, PHP_URL_PATH);
            if ($baseUrl && strpos($uri, $baseUrl) === 0) {
                $uri = substr($uri, strlen($baseUrl));
            }
            
            // Remove query string
            if (($pos = strpos($uri, '?')) !== false) {
                $uri = substr($uri, 0, $pos);
            }
            
            // Split URI into segments
            $segments = array_filter(explode('/', trim($uri, '/')));
            
            // Get controller and method
            $controllerName = ucfirst($segments[0] ?? self::$defaultController);
            $methodName = $segments[1] ?? self::$defaultMethod;
            
            // Get parameters
            $params = array_slice($segments, 2);
            
            // Add 'Controller' suffix
            $controllerClass = $controllerName . 'Controller';
            $controllerFile = ROOT_PATH . '/app/controllers/' . $controllerClass . '.php';
            
            if (!file_exists($controllerFile)) {
                throw new Exception("Controller not found: {$controllerFile}");
            }
            
            require_once $controllerFile;
            
            if (!class_exists($controllerClass)) {
                throw new Exception("Controller class not found: {$controllerClass}");
            }
            
            $controller = new $controllerClass();
            
            if (!method_exists($controller, $methodName)) {
                throw new Exception("Method not found: {$controllerClass}::{$methodName}");
            }
            
            return call_user_func_array([$controller, $methodName], $params);
            
        } catch (Exception $e) {
            error_log("Routing Error: " . $e->getMessage());
            
            if (DEBUG_MODE) {
                die("Routing Error: " . $e->getMessage());
            }
            
            header("HTTP/1.0 404 Not Found");
            die('Page not found');
        }
    }
    
    public static function url($path = '') {
        return self::$baseUrl . '/' . trim($path, '/');
    }
    
    public static function asset($path) {
        // Remove leading slashes
        $path = ltrim($path, '/');
        
        // Check if file exists
        $filePath = ROOT_PATH . '/public/assets/' . $path;
        if (!file_exists($filePath)) {
            error_log("Asset not found: " . $filePath);
            
            // If it's an image, return default AdminLTE logo
            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $path)) {
                return self::$baseUrl . '/assets/theme/admin-lte-3/dist/img/AdminLTELogo.png';
            }
            
            // For other files, return empty string
            return '';
        }
        
        return self::$baseUrl . '/assets/' . $path;
    }
}
?> 