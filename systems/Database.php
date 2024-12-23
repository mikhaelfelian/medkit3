<?php
class Database {
    private static $instance = null;
    private $conn = null;
    
    private function __construct() {
        try {
            $db_config = $GLOBALS['db_config'];
            
            $dsn = "mysql:host={$db_config['hostname']};dbname={$db_config['database']};charset={$db_config['charset']}";
            
            $this->conn = new PDO($dsn, $db_config['username'], $db_config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db_config['charset']}"
            ]);
            
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
} 