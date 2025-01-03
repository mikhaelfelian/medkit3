<?php
/**
 * Debug Helper
 * 
 * Contains debugging helper functions
 */
class DebugHelper {
    /**
     * Print data in pre tags for better readability
     * 
     * @param mixed $data Data to print
     * @param bool $die Whether to die after printing (default: false)
     * @return void
     */
    public static function pre($data, $die = false) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        
        if ($die) {
            die();
        }
    }
    
    /**
     * Print data in pre tags and die
     * 
     * @param mixed $data Data to print
     * @return void
     */
    public static function dd($data) {
        self::pre($data, true);
    }

    /**
     * Log data to error log
     * 
     * @param mixed $data Data to log
     * @param string $prefix Optional prefix for log message
     * @return void
     */
    public static function log($data, $prefix = '') {
        $message = $prefix ? "[$prefix] " : '';
        $message .= is_array($data) || is_object($data) ? print_r($data, true) : $data;
        error_log($message);
    }

    /**
     * Get variable type and value information
     * 
     * @param mixed $var Variable to debug
     * @param bool $die Whether to die after printing (default: false)
     * @return void
     */
    public static function dump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
} 