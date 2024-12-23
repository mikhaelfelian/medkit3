<?php
class BaseCore {
    public function __construct() {
        try {
            // Start session
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Register autoloader
            spl_autoload_register([$this, 'autoload']);
            
            // Initialize components
            $this->initializeComponents();
            
            // Dispatch the request
            BaseRouting::dispatch();
            
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }
    
    private function initializeComponents() {
        // Initialize database
        Database::getInstance();
        
        // Initialize security
        BaseSecurity::getInstance();
    }
    
    private function autoload($class) {
        $paths = [
            ROOT_PATH . '/systems/controllers/',
            ROOT_PATH . '/systems/models/',
            ROOT_PATH . '/systems/helpers/',
            ROOT_PATH . '/app/controllers/',
            ROOT_PATH . '/app/models/',
            ROOT_PATH . '/app/helpers/'
        ];
        
        foreach ($paths as $path) {
            $file = $path . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
    
    private function handleError($e) {
        error_log($e->getMessage());
        if (DEBUG_MODE) {
            die("Application Error: " . $e->getMessage());
        } else {
            header("Location: " . BASE_URL . "/error");
            exit;
        }
    }
}
?> 