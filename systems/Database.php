<?php
class Database {
    private static $instance = null;
    private $conn = null;
    
    private function __construct() {
        try {
            // Get database configuration
            $db_config = $GLOBALS['db_config'];
            
            // Ensure charset is set
            $charset = isset($db_config['charset']) ? $db_config['charset'] : 'utf8mb4';
            
            // Build DSN
            $dsn = "mysql:host={$db_config['hostname']};dbname={$db_config['database']};charset={$charset}";
            
            try {
                $this->conn = new PDO($dsn, $db_config['username'], $db_config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}"
                ]);
            } catch (PDOException $e) {
                // Log the error details but don't expose sensitive info
                error_log("Database Connection Error: " . $e->getMessage());
                
                // Create user-friendly error message
                $errorMessage = $this->formatDatabaseError($e);
                
                // Extract data for exception page
                $data = [
                    'debug_message' => DEBUG_MODE ? $errorMessage : 'Database connection failed',
                    'trace' => $e->getTraceAsString()
                ];
                
                // Set HTTP response code
                http_response_code(500);
                
                // Extract data for the view
                extract($data);
                
                // Render exception view
                require_once APP_PATH . '/views/errors/exception.php';
                exit;
            }
            
        } catch (Exception $e) {
            error_log("Database Configuration Error: " . $e->getMessage());
            throw new Exception("Database configuration error. Please check your database settings.");
        }
    }
    
    private function formatDatabaseError($e) {
        $message = $e->getMessage();
        
        // Handle common database errors
        if (strpos($message, 'Access denied') !== false) {
            return "Database connection failed: Invalid credentials or access denied. Please check your database configuration.";
        }
        
        if (strpos($message, "Unknown database") !== false) {
            return "Database connection failed: Database does not exist. Please check your database name.";
        }
        
        if (strpos($message, "Connection refused") !== false) {
            return "Database connection failed: Server connection refused. Please check if database server is running.";
        }
        
        if (strpos($message, "Unknown character set") !== false) {
            return "Database connection failed: Invalid character set. Please check your database charset configuration.";
        }
        
        // Default error message
        return "Database connection failed: " . $e->getMessage();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = new self();
            } catch (Exception $e) {
                error_log("Database Instance Error: " . $e->getMessage());
                throw $e;
            }
        }
        return self::$instance;
    }
    
    public function getConnection() {
        if ($this->conn === null) {
            throw new Exception("Database connection not established");
        }
        return $this->conn;
    }
    
    public function __destruct() {
        $this->conn = null;
    }
} 