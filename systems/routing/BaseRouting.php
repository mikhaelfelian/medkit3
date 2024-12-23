<?php
class BaseRouting {
    protected static $routes = [];
    protected static $notFoundCallback;
    protected static $baseUrl;
    protected static $defaultController = 'Pasien';
    protected static $defaultMethod = 'index';
    
    public static function init($baseUrl) {
        self::$baseUrl = $baseUrl;
    }
    
    public static function setDefaults($controller = 'Home', $method = 'index') {
        self::$defaultController = $controller;
        self::$defaultMethod = $method;
    }
    
    public static function add($method, $path, $callback) {
        $path = trim($path, '/');
        self::$routes[$path] = [
            'method' => strtoupper($method),
            'callback' => $callback
        ];
    }
    
    public static function get($path, $callback) {
        self::add('GET', $path, $callback);
    }
    
    public static function post($path, $callback) {
        self::add('POST', $path, $callback);
    }
    
    public static function notFound($callback) {
        self::$notFoundCallback = $callback;
    }
    
    public static function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Parse the URI to remove script name and base path
        $parsedUri = parse_url($uri);
        $path = $parsedUri['path'];
        
        // Remove script name if it exists
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/') {
            $path = str_replace($scriptName, '', $path);
        }
        
        // Remove query string
        if (isset($parsedUri['query'])) {
            $path = str_replace('?' . $parsedUri['query'], '', $path);
        }
        
        // Clean the path
        $path = trim($path, '/');
        
        // If empty path, use defaults
        if (empty($path)) {
            $controller = self::$defaultController;
            $method = self::$defaultMethod;
            return self::executeController($controller, $method);
        }
        
        // Check defined routes
        foreach (self::$routes as $route => $details) {
            if ($details['method'] !== $method) {
                continue;
            }
            
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = "#^{$pattern}$#";
            
            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, function($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);
                
                if (is_callable($details['callback'])) {
                    return call_user_func_array($details['callback'], $params);
                } else if (is_string($details['callback'])) {
                    list($controller, $method) = explode('@', $details['callback']);
                    return self::executeController($controller, $method, $params);
                }
            }
        }
        
        // Handle 404
        if (self::$notFoundCallback) {
            return call_user_func(self::$notFoundCallback);
        }
        
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
    
    protected static function executeController($controller, $method, $params = []) {
        $controllerClass = $controller . 'Controller';
        $controllerFile = ROOT_PATH . '/app/controllers/' . $controllerClass . '.php';
        
        if (!file_exists($controllerFile)) {
            throw new Exception("Controller file not found: {$controllerFile}");
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller class not found: {$controllerClass}");
        }
        
        $controllerInstance = new $controllerClass();
        
        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Method not found: {$method}");
        }
        
        return call_user_func_array([$controllerInstance, $method], $params);
    }
    
    public static function url($path = '') {
        return self::$baseUrl . '/' . trim($path, '/');
    }
}
?> 