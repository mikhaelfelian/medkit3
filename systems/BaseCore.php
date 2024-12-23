<?php
class BaseCore {
    public function __construct() {
        // Load config
        require_once ROOT_PATH . '/config/config.php';
        
        // Load core classes
        require_once ROOT_PATH . '/systems/Database.php';
        require_once ROOT_PATH . '/systems/routing/BaseRouting.php';
        require_once ROOT_PATH . '/systems/controllers/BaseController.php';
        require_once ROOT_PATH . '/systems/models/BaseModel.php';
        require_once ROOT_PATH . '/systems/helpers/ViewHelper.php';
        require_once ROOT_PATH . '/systems/BaseForm.php';
        
        // Register autoloader for models
        spl_autoload_register(function ($class) {
            // Check if class ends with 'Model'
            if (substr($class, -5) === 'Model') {
                $file = ROOT_PATH . '/app/models/' . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        });
        
        // Initialize database connection
        global $conn;
        $conn = Database::getInstance()->getConnection();
        
        // Initialize routing
        BaseRouting::init(BASE_URL);
        BaseRouting::dispatch();
    }
}
?> 