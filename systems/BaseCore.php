<?php
class BaseCore {
    public function __construct() {
        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Register autoloader
        spl_autoload_register(function ($class) {
            // Load base classes first
            if (strpos($class, 'Base') === 0) {
                // Check in systems/controllers
                $file = SYSTEM_PATH . '/controllers/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
                
                // Check in app/core
                $file = APP_PATH . '/core/' . $class . '.php';
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
        });

        // Load core libraries and helpers
        require_once SYSTEM_PATH . '/libraries/Logger.php';
        require_once SYSTEM_PATH . '/libraries/Input.php';
        require_once SYSTEM_PATH . '/libraries/Security.php';
        require_once SYSTEM_PATH . '/helpers/url_helper.php';
        require_once SYSTEM_PATH . '/helpers/Notification.php';
        
        // Initialize routing
        BaseRouting::dispatch();
    }
}
?> 