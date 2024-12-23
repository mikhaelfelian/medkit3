<?php
class BaseController {
    protected $model;
    protected $viewHelper;
    protected $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->viewHelper = new ViewHelper();
    }
    
    protected function loadModel($modelName) {
        try {
            // Add 'Model' suffix if not present
            if (substr($modelName, -5) !== 'Model') {
                $modelName .= 'Model';
            }
            
            // Check if model file exists
            $modelFile = ROOT_PATH . '/app/models/' . $modelName . '.php';
            if (!file_exists($modelFile)) {
                throw new Exception("Model file not found: {$modelFile}");
            }
            
            // Load model file if not already loaded
            if (!class_exists($modelName)) {
                require_once $modelFile;
            }
            
            // Create model instance
            $this->model = new $modelName($this->conn);
            
            return $this->model;
        } catch (Exception $e) {
            error_log("Error loading model: " . $e->getMessage());
            throw new Exception("Model {$modelName} not found");
        }
    }
    
    protected function view($view, $data = []) {
        try {
            // Check if PengaturanModel class exists
            if (!class_exists('PengaturanModel')) {
                require_once ROOT_PATH . '/app/models/PengaturanModel.php';
            }
            
            // Load settings for all views
            $pengaturanModel = new PengaturanModel($this->conn);
            
            // Debug connection
            if (!$this->conn) {
                throw new Exception("Database connection is not available");
            }
            
            $settings = $pengaturanModel->getSettings();
            
            // Debug settings
            if (!$settings) {
                error_log("Settings is null or empty");
                $settings = new stdClass();
                $settings->judul_app = 'NUSANTARA HMVC';
                $settings->logo = 'theme/admin-lte-3/dist/img/AdminLTELogo.png';
                $settings->favicon = 'theme/admin-lte-3/dist/img/AdminLTELogo.png';
            }
            
            // Merge settings with view data
            $data['settings'] = $settings;
            
            return $this->viewHelper->render($view, $data);
        } catch (Exception $e) {
            error_log("View Error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            // Show detailed error in development
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                die("View Error: " . $e->getMessage() . "<br>Stack trace:<pre>" . $e->getTraceAsString() . "</pre>");
            } else {
                die("An error occurred while loading the view. Please check the error logs.");
            }
        }
    }
    
    protected function redirect($url) {
        $url = BaseRouting::url($url);
        header("Location: {$url}");
        exit;
    }
    
    protected function input($key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    protected function validate($rules) {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $this->input($field);
            
            if (!is_array($fieldRules)) {
                $fieldRules = explode('|', $fieldRules);
            }
            
            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field] = ucfirst($field) . ' is required';
                }
                
                if ($rule === 'numeric' && !is_numeric($value)) {
                    $errors[$field] = ucfirst($field) . ' must be a number';
                }
                
                if (strpos($rule, 'min:') === 0) {
                    $min = substr($rule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field] = ucfirst($field) . " must be at least {$min} characters";
                    }
                }
            }
        }
        
        return empty($errors) ? true : $errors;
    }
}
?> 