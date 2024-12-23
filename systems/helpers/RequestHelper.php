<?php
class RequestHelper {
    protected $inputs;
    
    public function __construct() {
        $this->inputs = array_merge($_GET, $_POST);
    }
    
    public function input($key = null, $default = null) {
        if ($key === null) {
            return $this->inputs;
        }
        return $this->inputs[$key] ?? $default;
    }
    
    public function validate($rules) {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            // Convert string rules to array
            if (!is_array($fieldRules)) {
                $fieldRules = explode('|', $fieldRules);
            }
            
            $value = $this->input($field);
            
            foreach ($fieldRules as $rule) {
                // Parse rule with parameters
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleParams = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];
                
                switch ($ruleName) {
                    case 'required':
                        if (empty($value) && $value !== '0') {
                            $errors[$field][] = ucfirst($field) . ' is required';
                        }
                        break;
                        
                    case 'min':
                        $min = $ruleParams[0] ?? 0;
                        if (strlen($value) < $min) {
                            $errors[$field][] = ucfirst($field) . ' must be at least ' . $min . ' characters';
                        }
                        break;
                        
                    // Add more validation rules as needed
                }
            }
        }
        
        return empty($errors) ? true : $errors;
    }
    
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function getSegments() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        return explode('/', $uri);
    }
} 