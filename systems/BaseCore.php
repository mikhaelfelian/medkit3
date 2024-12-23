<?php
class BaseCore {
    public function __construct() {
        try {
            // Start session for CSRF protection
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Show errors in development
            if (!defined('ENVIRONMENT') || ENVIRONMENT === 'development') {
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }

            // Load configurations
            $this->loadConfigs();
            
            // Dispatch route
            BaseRouting::dispatch();
            
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                die("Error: " . $e->getMessage());
            } else {
                die("An error occurred. Please try again later.");
            }
        }
    }
    
    protected function loadConfigs() {
        // Load main config first
        require_once ROOT_PATH . '/config/config.php';
        
        // Load BaseSecurity class first
        require_once ROOT_PATH . '/systems/BaseSecurity.php';
        
        // Load security config
        $security_config = require ROOT_PATH . '/config/security.php';
        BaseSecurity::getInstance($security_config);
        
        // Load required base classes
        require_once ROOT_PATH . '/systems/routing/BaseRouting.php';
        require_once ROOT_PATH . '/systems/controllers/BaseController.php';
        require_once ROOT_PATH . '/systems/models/BaseModel.php';
        require_once ROOT_PATH . '/systems/BaseForm.php';
        require_once ROOT_PATH . '/systems/helpers/RequestHelper.php';
        require_once ROOT_PATH . '/systems/helpers/ResponseHelper.php';
        require_once ROOT_PATH . '/systems/helpers/ViewHelper.php';
        
        // Load database config
        require_once ROOT_PATH . '/config/database.php';
        
        // Initialize routing with base URL
        BaseRouting::init(BASE_URL);
        
        // Load routes configuration
        require_once ROOT_PATH . '/config/routes.php';
        
        require_once ROOT_PATH . '/systems/BaseNotification.php';
        require_once ROOT_PATH . '/app/library/Notification.php';
        
        // Load helpers
        require_once ROOT_PATH . '/app/helpers/GenerateNoRM.php';
        
        // Load encryption class
        require_once ROOT_PATH . '/systems/encryption/Encrypt.php';
        
        // Load helpers
        require_once ROOT_PATH . '/systems/helpers/AssetHelper.php';
    }
}
?> 