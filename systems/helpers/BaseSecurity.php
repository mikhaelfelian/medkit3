<?php
class BaseSecurity {
    private static $instance = null;
    
    private function __construct() {}
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        
        // Remove HTML tags
        $input = strip_tags($input);
        
        // Convert special characters to HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        return $input;
    }
    
    public function generateToken() {
        return bin2hex(random_bytes(32));
    }
    
    public function validateToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public function xssClean($data) {
        // Handle arrays recursively
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->xssClean($value);
            }
            return $data;
        }
        
        // Convert special characters to HTML entities
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        
        // Remove JavaScript events
        $data = preg_replace('#on\w+\s*=\s*["\'][^"\']*["\']#i', '', $data);
        
        return $data;
    }
    
    public function escapeHtml($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
} 