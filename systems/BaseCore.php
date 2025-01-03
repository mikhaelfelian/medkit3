<?php
class BaseCore {
    public function __construct() {
        try {
            // Start session if not started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Load core system files first
            $this->loadCoreFiles();

            // Load required helpers in specific order
            $this->loadCoreHelpers();
            
            // Register class autoloader
            $this->registerAutoloader();
            
            // Initialize routing
            BaseRouting::dispatch();
            
        } catch (Exception $e) {
            // Load BaseController if not loaded
            if (!class_exists('BaseController')) {
                require_once SYSTEM_PATH . '/controllers/BaseController.php';
            }
            BaseController::handleException($e);
        }
    }
    
    private function loadCoreFiles() {
        // Core system files that must be loaded in order
        $coreFiles = [
            '/controllers/BaseController.php',
            '/models/BaseModel.php',
            '/routing/BaseRouting.php',
            '/forms/BaseForm.php',
            '/helpers/ViewHelper.php'
        ];
        
        foreach ($coreFiles as $file) {
            $filePath = SYSTEM_PATH . $file;
            if (!file_exists($filePath)) {
                throw new Exception("Core file not found: {$filePath}");
            }
            require_once $filePath;
        }
    }
    
    private function loadCoreHelpers() {
        // Core helpers that must be loaded before anything else
        $coreHelpers = [
            'NotificationHelper',  // Load this first
            'Notification',        // Then load the alias
            'UrlHelper',          // Changed from 'Url' to 'UrlHelper'
            'FormHelper',         // Changed from 'Form' to 'FormHelper'
            'SecurityHelper'      // Changed from 'Security' to 'SecurityHelper'
        ];
        
        foreach ($coreHelpers as $helper) {
            $helperFile = SYSTEM_PATH . '/helpers/' . $helper . '.php';
            if (!file_exists($helperFile)) {
                throw new Exception("Core helper not found: {$helperFile}");
            }
            require_once $helperFile;
        }
    }

    private function registerAutoloader() {
        spl_autoload_register(function ($class) {
            // Load base classes first
            if (strpos($class, 'Base') === 0) {
                $file = SYSTEM_PATH . '/controllers/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
            
            // Check for Controller class
            if (strpos($class, 'Controller') !== false) {
                $file = APP_PATH . '/controllers/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
            
            // Check for Model class
            if (strpos($class, 'Model') !== false) {
                $file = APP_PATH . '/models/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }

            // Check for Helper class
            if (strpos($class, 'Helper') !== false) {
                // Try app helpers first
                $file = APP_PATH . '/helpers/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
                
                // Then try system helpers
                $file = SYSTEM_PATH . '/helpers/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
}
?> 