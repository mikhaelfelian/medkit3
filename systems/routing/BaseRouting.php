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
            $uri = $_SERVER['REQUEST_URI'];
            $path = parse_url($uri, PHP_URL_PATH);
            
            // Remove base path and index.php from URL
            $path = str_replace(['index.php', '/medkit3'], '', $path);
            
            // Split into segments
            $segments = array_values(array_filter(explode('/', $path)));
            
            // Default controller and method
            $controller = !empty($segments[0]) ? $segments[0] : 'home';
            $method = !empty($segments[1]) ? str_replace('-', '_', $segments[1]) : 'index';
            $params = array_slice($segments, 2);
            
            // Build controller class name
            $controllerClass = ucfirst($controller) . 'Controller';
            $controllerFile = APP_PATH . '/controllers/' . $controllerClass . '.php';
            
            if (!file_exists($controllerFile)) {
                throw new Exception('Controller not found: ' . $controllerClass);
            }
            
            require_once $controllerFile;
            
            if (!class_exists($controllerClass)) {
                throw new Exception('Controller class not found: ' . $controllerClass);
            }
            
            $controllerInstance = new $controllerClass();
            
            if (!method_exists($controllerInstance, $method)) {
                throw new Exception('Method not found: ' . $method);
            }
            
            return call_user_func_array([$controllerInstance, $method], $params);
            
        } catch (Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // Return JSON error for AJAX requests
                header('Content-Type: application/json');
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
            
            // Show error page for normal requests
            require_once APP_PATH . '/views/errors/404.php';
        }
    }
    
    public static function url($path = '', $params = []) {
        $url = rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
        
        if (!empty($params)) {
            $queryString = http_build_query($params);
            $url .= '?' . $queryString;
        }
        
        return $url;
    }
    
    protected static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $dirname = dirname($scriptName);
        $baseUrl = $protocol . '://' . $host . ($dirname === '/' ? '' : $dirname);
        return rtrim($baseUrl, '/');
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