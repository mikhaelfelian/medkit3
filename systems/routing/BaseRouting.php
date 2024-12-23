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
        // Get the current URI
        $uri = $_SERVER['REQUEST_URI'];
        $baseFolder = dirname($_SERVER['SCRIPT_NAME']);
        
        // Remove base folder from URI if it exists
        if ($baseFolder !== '/' && strpos($uri, $baseFolder) === 0) {
            $uri = substr($uri, strlen($baseFolder));
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
        
        // Check if controller exists
        $controllerFile = ROOT_PATH . '/app/controllers/' . $controllerClass . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                
                if (method_exists($controller, $methodName)) {
                    return call_user_func_array([$controller, $methodName], $params);
                }
            }
        }
        
        // Handle 404
        header("HTTP/1.0 404 Not Found");
        die('Page not found');
    }
    
    public static function url($path = '') {
        return self::$baseUrl . '/' . trim($path, '/');
    }
    
    public static function asset($path) {
        return self::$baseUrl . '/assets/' . ltrim($path, '/');
    }
}
?> 