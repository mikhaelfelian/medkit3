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
        $this->logFile = ROOT_PATH . '/logs/error_log.log';
        
        // Create logs directory if it doesn't exist
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Create log file if it doesn't exist
        if (!file_exists($this->logFile)) {
            file_put_contents($this->logFile, '');
            chmod($this->logFile, 0644);
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Log a message with timestamp
     * 
     * @param string $message Message to log
     * @param string $type Log type (ERROR, INFO, DEBUG, etc)
     * @return void
     */
    public function log($message, $type = 'ERROR') {
        try {
            $timestamp = date('Y-m-d H:i:s');
            $formattedMessage = "[{$timestamp}] {$type}: {$message}" . PHP_EOL;
            
            // Get backtrace for error location
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $caller = isset($trace[1]) ? $trace[1] : $trace[0];
            
            // Add file and line info
            $file = isset($caller['file']) ? basename($caller['file']) : 'unknown';
            $line = $caller['line'] ?? 'unknown';
            $formattedMessage = str_replace(
                "{$type}:", 
                "{$type} [{$file}:{$line}]:", 
                $formattedMessage
            );
            
            file_put_contents($this->logFile, $formattedMessage, FILE_APPEND);
        } catch (Exception $e) {
            error_log("Logger Error: " . $e->getMessage());
        }
    }
} 