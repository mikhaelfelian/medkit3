<?php
require_once SYSTEM_PATH . '/libraries/Logger.php';

class BaseRouting {
    private static $basePath = null;
    
    private static function getBasePath() {
        if (self::$basePath === null) {
            self::$basePath = parse_url(BASE_URL, PHP_URL_PATH);
        }
        return self::$basePath;
    }
    
    public static function dispatch() {
        try {
            // Get the URL path
            $path = $_SERVER['REQUEST_URI'];
            
            // Remove base path from URL
            $basePath = self::getBasePath();
            if ($basePath && strpos($path, $basePath) === 0) {
                $path = substr($path, strlen($basePath));
            }
            
            // Remove query string if exists
            if (($pos = strpos($path, '?')) !== false) {
                $path = substr($path, 0, $pos);
            }
            
            // Remove trailing slash
            $path = trim($path, '/');
            
            // If empty path, use default controller/action
            if (empty($path)) {
                $controller = 'Home';
                $action = 'index';
                $params = [];
            } else {
                // Split path into segments
                $segments = explode('/', $path);
                
                // Get controller
                $controller = ucfirst(array_shift($segments));
                
                // Get action
                $action = !empty($segments) ? array_shift($segments) : 'index';
                
                // Remaining segments are parameters
                $params = $segments;
            }
            
            // Add Controller suffix
            $controllerClass = $controller . 'Controller';
            $controllerFile = APP_PATH . '/controllers/' . $controllerClass . '.php';
            
            // Check if controller exists
            if (!file_exists($controllerFile)) {
                throw new Exception("Controller not found: {$controllerClass}");
            }
            
            // Create controller instance
            $controller = new $controllerClass();
            
            // Check if action exists
            if (!method_exists($controller, $action)) {
                throw new Exception("Action not found: {$action}");
            }
            
            // Call the action with parameters
            return call_user_func_array([$controller, $action], $params);
            
        } catch (Exception $e) {
            // Log the error
            Logger::getInstance()->error("Routing Error: " . $e->getMessage(), [
                'exception' => $e
            ]);
            
            // Handle exception using static method
            BaseController::handleException($e);
        }
    }
    
    public static function url($path = '') {
        return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    }
    
    public static function asset($path = '') {
        return self::url('public/assets/' . ltrim($path, '/'));
    }
    
    public static function getCurrentController() {
        $uri = $_SERVER['REQUEST_URI'];
        $basePath = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $path = str_replace($basePath, '', $uri);
        
        // Remove query string if present
        if (($pos = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $pos);
        }
        
        // Remove leading/trailing slashes
        $path = trim($path, '/');
        
        // If empty, return default controller
        if (empty($path)) {
            return '';
        }
        
        // Return first segment
        $segments = explode('/', $path);
        return $segments[0];
    }
}
?> 