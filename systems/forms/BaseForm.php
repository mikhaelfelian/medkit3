<?php
class BaseForm {
    private static $instance = null;
    private $errors = [];
    private $old = [];
    
    private function __construct() {
        // Store old input on POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->old = $_POST;
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function setErrors($errors) {
        $this->errors = $errors;
    }
    
    public function hasError($field) {
        return isset($this->errors[$field]);
    }
    
    public function getError($field) {
        return $this->errors[$field] ?? '';
    }
    
    public function old($key, $default = '') {
        return $this->old[$key] ?? $default;
    }
    
    public function inputClass($field, $defaultClass = 'form-control') {
        return $defaultClass . ($this->hasError($field) ? ' is-invalid' : '');
    }
    
    public function input($type, $name, $value = '', $attributes = []) {
        $value = $this->old($name, $value);
        $class = $this->inputClass($name);
        $attrs = $this->buildAttributes(array_merge(['class' => $class], $attributes));
        
        return sprintf(
            '<input type="%s" name="%s" value="%s"%s>',
            $type,
            $name,
            htmlspecialchars($value),
            $attrs
        );
    }
    
    public function textarea($name, $value = '', $attributes = []) {
        $value = $this->old($name, $value);
        $class = $this->inputClass($name);
        $attrs = $this->buildAttributes(array_merge(['class' => $class], $attributes));
        
        return sprintf(
            '<textarea name="%s"%s>%s</textarea>',
            $name,
            $attrs,
            htmlspecialchars($value)
        );
    }
    
    public function select($name, $options, $selected = '', $attributes = []) {
        $selected = $this->old($name, $selected);
        $class = $this->inputClass($name);
        $attrs = $this->buildAttributes(array_merge(['class' => $class], $attributes));
        
        $html = sprintf('<select name="%s"%s>', $name, $attrs);
        
        foreach ($options as $value => $label) {
            $html .= sprintf(
                '<option value="%s"%s>%s</option>',
                $value,
                $value == $selected ? ' selected' : '',
                htmlspecialchars($label)
            );
        }
        
        return $html . '</select>';
    }
    
    private function buildAttributes($attributes) {
        $html = '';
        foreach ($attributes as $key => $value) {
            $html .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }
        return $html;
    }
    
    public function open($action = '', $method = 'POST', $attributes = []) {
        $attrs = $this->buildAttributes($attributes);
        $html = sprintf('<form action="%s" method="%s"%s>', $action, $method, $attrs);
        if (strtoupper($method) === 'POST') {
            $html .= $this->csrf();
        }
        return $html;
    }
    
    public function close() {
        return '</form>';
    }
    
    public static function csrf() {
        $security = new Security();
        return sprintf(
            '<input type="hidden" name="csrf_token" value="%s">',
            $security->getCSRFToken()
        );
    }
} 