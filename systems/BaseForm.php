<?php
class BaseForm {
    private static $instance = null;
    private $old = [];
    private $errors = [];
    
    private function __construct() {
        // Initialize session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get input value (from POST, GET, or old input)
     */
    public function input($key, $default = '') {
        // First check old input
        if (isset($this->old[$key])) {
            return $this->old[$key];
        }
        
        // Then check POST
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        
        // Then check GET
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        
        // Finally return default
        return $default;
    }
    
    /**
     * Generate CSRF token field
     */
    public function csrf() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    }

    /**
     * Verify CSRF token
     */
    public function verifyCsrfToken($token) {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        
        $valid = hash_equals($_SESSION['csrf_token'], $token);
        
        // Generate new token after verification
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        return $valid;
    }
    
    /**
     * Set old input data for form repopulation
     */
    public function setOld($data) {
        $this->old = $data;
    }
    
    /**
     * Get old input value
     */
    public function old($key, $default = '') {
        return $this->old[$key] ?? $default;
    }
    
    /**
     * Set validation errors
     */
    public function setErrors($errors) {
        $this->errors = $errors;
    }
    
    /**
     * Get error message for a field with AdminLTE styling
     */
    public function error($field) {
        if (isset($this->errors[$field])) {
            return '<div class="invalid-feedback d-block">' . $this->errors[$field] . '</div>';
        }
        return '';
    }
    
    /**
     * Check if field has error
     */
    public function hasError($field) {
        return isset($this->errors[$field]);
    }
    
    /**
     * Get all errors
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Get input class with validation state
     */
    public function inputClass($field, $defaultClass = 'form-control') {
        return $defaultClass . (isset($this->errors[$field]) ? ' is-invalid' : '');
    }
    
    /**
     * Create a select input
     */
    public function select($name, $options, $selected = '', $attributes = []) {
        $attrs = '';
        foreach ($attributes as $key => $value) {
            $attrs .= " {$key}=\"{$value}\"";
        }
        
        $html = "<select name=\"{$name}\"{$attrs}>\n";
        
        foreach ($options as $value => $label) {
            $isSelected = ($value == $this->input($name, $selected)) ? ' selected' : '';
            $html .= "    <option value=\"{$value}\"{$isSelected}>{$label}</option>\n";
        }
        
        $html .= "</select>";
        return $html;
    }
    
    /**
     * Create a text input
     */
    public function text($name, $value = '', $attributes = []) {
        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= " {$key}=\"{$val}\"";
        }
        
        $value = $this->input($name, $value);
        return "<input type=\"text\" name=\"{$name}\" value=\"{$value}\"{$attrs}>";
    }
    
    /**
     * Create a hidden input
     */
    public function hidden($name, $value = '', $attributes = []) {
        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= " {$key}=\"{$val}\"";
        }
        
        $value = $this->input($name, $value);
        return "<input type=\"hidden\" name=\"{$name}\" value=\"{$value}\"{$attrs}>";
    }
}
?> 