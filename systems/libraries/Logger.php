<?php
/**
 * Logger Library
 * 
 * Handles error logging to custom log file
 */
class Logger {
    private static $instance = null;
    private $logFile;
    
    private function __construct() {
        $logDir = ROOT_PATH . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $this->logFile = $logDir . '/error.log';
        
        // Create log file if it doesn't exist
        if (!file_exists($this->logFile)) {
            touch($this->logFile);
            chmod($this->logFile, 0644);
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function error($message, $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] ERROR: {$message}\n";
        
        if (!empty($context)) {
            $logMessage .= "Context: " . json_encode($context) . "\n";
        }
        
        if (isset($context['exception'])) {
            $e = $context['exception'];
            $logMessage .= "File: {$e->getFile()}:{$e->getLine()}\n";
            $logMessage .= "Stack trace:\n{$e->getTraceAsString()}\n";
        }
        
        error_log($logMessage, 3, $this->logFile);
    }
} 