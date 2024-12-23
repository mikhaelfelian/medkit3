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
        if (class_exists($modelName)) {
            $this->model = new $modelName($this->conn);
        } else {
            throw new Exception("Model {$modelName} not found");
        }
    }
    
    protected function view($view, $data = []) {
        try {
            // Load settings for all views
            $pengaturanModel = new PengaturanModel($this->conn);
            $settings = $pengaturanModel->findOne();
            
            // Merge settings with view data
            $data['settings'] = $settings;
            
            return $this->viewHelper->render($view, $data);
        } catch (Exception $e) {
            die("An error occurred while loading the view: " . $e->getMessage());
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