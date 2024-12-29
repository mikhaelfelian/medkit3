<?php
/**
 * Debug Helper
 * 
 * Contains debugging helper functions
 */
class Debug {
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
} 