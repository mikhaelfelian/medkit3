<?php
class BaseController {
    protected $model;
    protected $viewHelper;
    protected $conn;
    protected $security;
    
    public function __construct() {
        // Get database connection
        $this->conn = Database::getInstance()->getConnection();
        $this->viewHelper = new ViewHelper();
        $this->security = BaseSecurity::getInstance();
        
        // Validate CSRF token for POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->security->validateRequest();
        }
    }
    
    protected function loadModel($modelName) {
        try {
            // Add 'Model' suffix if not present
            if (substr($modelName, -5) !== 'Model') {
                $modelName .= 'Model';
            }
            
            // Check if model file exists
            $modelFile = APP_PATH . '/models/' . $modelName . '.php';
            if (!file_exists($modelFile)) {
                throw new Exception("Model file not found: {$modelFile}");
            }
            
            // Load model file if not already loaded
            if (!class_exists($modelName)) {
                require_once $modelFile;
            }
            
            // Create model instance with database connection
            $this->model = new $modelName($this->conn);
            
            return $this->model;
        } catch (Exception $e) {
            error_log("Model Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    protected function view($view, $data = []) {
        try {
            // Extract data to variables
            extract($data);
            
            // Start output buffering
            ob_start();
            
            // Include the view file
            $viewFile = APP_PATH . '/views/' . $view . '.php';
            if (!file_exists($viewFile)) {
                throw new Exception("View file not found: {$viewFile}");
            }
            
            include $viewFile;
            
            // Get the view content
            $content = ob_get_clean();
            
            // Include the layout
            $layoutFile = APP_PATH . '/views/layouts/main.php';
            if (!file_exists($layoutFile)) {
                throw new Exception("Layout file not found: {$layoutFile}");
            }
            
            include $layoutFile;
            
        } catch (Exception $e) {
            error_log("View Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit;
    }
    
    protected function input($key = null, $default = null) {
        if ($key === null) {
            return array_merge($_GET, $_POST);
        }
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}
?> 