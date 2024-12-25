<?php
class InputSanitizer {
    public static function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }
        
        // Remove whitespace
        $data = trim($data);
        
        // Convert special characters to HTML entities
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        
        // Remove any SQL injection attempts
        $data = str_replace(
            ['SELECT', 'INSERT', 'UPDATE', 'DELETE', 'DROP', 'UNION', '--', '/*', '*/'], 
            '', 
            strtoupper($data)
        );
        
        return $data;
    }
} 