<?php
class Input {
    private static $instance = null;
    
    private function __construct() {
        // Private constructor to prevent direct creation
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get sanitized POST data
     */
    public function post($key = null, $default = null) {
        if ($key === null) {
            return $this->sanitizeArray($_POST);
        }
        return $this->sanitize($_POST[$key] ?? $default);
    }
    
    /**
     * Get sanitized GET data
     */
    public function get($key = null, $default = null) {
        if ($key === null) {
            return $this->sanitizeArray($_GET);
        }
        return $this->sanitize($_GET[$key] ?? $default);
    }
    
    /**
     * Sanitize single input value
     */
    private function sanitize($value) {
        if (is_array($value)) {
            return $this->sanitizeArray($value);
        }
        
        // Remove whitespace
        $value = trim($value);
        
        // Remove HTML tags
        $value = strip_tags($value);
        
        // Convert special characters to HTML entities
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        
        // Remove SQL injection patterns
        $value = $this->removeSQLInjectionPatterns($value);
        
        return $value;
    }
    
    /**
     * Sanitize array of values
     */
    private function sanitizeArray($array) {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$key] = $this->sanitize($value);
        }
        return $result;
    }
    
    /**
     * Remove common SQL injection patterns
     */
    private function removeSQLInjectionPatterns($value) {
        $patterns = [
            '/\b(SELECT|INSERT|UPDATE|DELETE|DROP|UNION|ALTER)\b/i',
            '/[;\'"\\\\]/',
            '/--/',
            '/\/\*|\*\//'
        ];
        return preg_replace($patterns, '', $value);
    }
} 