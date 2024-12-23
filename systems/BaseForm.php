<?php
class BaseForm {
    private static $instance = null;
    private $errors = [];
    private $old = [];
    private $csrf_token;
    
    private function __construct() {
        $this->csrf_token = $this->generateCsrfToken();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function csrf() {
        return '<input type="hidden" name="csrf_token" value="' . $this->csrf_token . '">';
    }
    
    public function csrfField() {
        return $this->csrf();
    }
    
    private function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public function verifyCsrfToken($token) {
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public function setErrors($errors) {
        $this->errors = $errors;
    }
    
    public function error($field) {
        return $this->errors[$field] ?? '';
    }
    
    public function hasError($field) {
        return isset($this->errors[$field]);
    }
    
    public function setOld($data) {
        $this->old = $data;
    }
    
    public function old($field, $default = '') {
        return $this->old[$field] ?? $default;
    }
    
    public function input($field, $default = '') {
        return $_POST[$field] ?? $_GET[$field] ?? $this->old($field, $default);
    }
    
    public function inputClass($field, $defaultClass = '') {
        return $this->hasError($field) 
            ? trim($defaultClass . ' is-invalid')
            : $defaultClass;
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
     * Create a textarea input
     */
    public function textarea($name, $value = '', $attributes = []) {
        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= " {$key}=\"{$val}\"";
        }
        
        $value = $this->input($name, $value);
        return "<textarea name=\"{$name}\"{$attrs}>{$value}</textarea>";
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
    
    /**
     * Create a password input
     */
    public function password($name, $attributes = []) {
        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= " {$key}=\"{$val}\"";
        }
        
        return "<input type=\"password\" name=\"{$name}\"{$attrs}>";
    }
    
    /**
     * Create an email input
     */
    public function email($name, $value = '', $attributes = []) {
        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= " {$key}=\"{$val}\"";
        }
        
        $value = $this->input($name, $value);
        return "<input type=\"email\" name=\"{$name}\" value=\"{$value}\"{$attrs}>";
    }
    
    /**
     * Get error message for a field with AdminLTE styling
     */
    public function getError($field) {
        if (isset($this->errors[$field])) {
            return '<div class="invalid-feedback d-block">' . $this->errors[$field] . '</div>';
        }
        return '';
    }
    
    /**
     * Get input class with validation state
     */
    public function getInputClass($field, $defaultClass = 'form-control') {
        return $defaultClass . (isset($this->errors[$field]) ? ' is-invalid' : '');
    }
}
?> 