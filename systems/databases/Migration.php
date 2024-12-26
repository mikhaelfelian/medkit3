<?php
/**
 * Base Migration Class
 * 
 * All migrations should extend this class
 */
abstract class Migration {
    /**
     * Database connection
     * @var PDO
     */
    protected $db;
    protected $prefix;
    
    /**
     * Constructor
     * 
     * @param PDO $db Database connection
     */
    public function __construct($db) {
        $this->db = $db;
        $this->prefix = $GLOBALS['db_config']['prefix'];
    }
    
    protected function getTableName($name) {
        // If name already starts with prefix, don't add it again
        if (strpos($name, $this->prefix) === 0) {
            return $name;
        }
        return $this->prefix . $name;
    }
    
    /**
     * Run the migration
     * 
     * @return bool Success status
     */
    public function migrate() {
        try {
            $this->db->beginTransaction();
            
            // Get start time
            $startTime = microtime(true);
            
            // Execute migration SQL
            $sql = $this->up();
            $this->db->exec($sql);
            
            // Calculate execution time
            $executionTime = round(microtime(true) - $startTime, 4);
            
            // Log the migration with more details
            $stmt = $this->db->prepare("
                INSERT INTO `" . $this->getTableName('migrations') . "` 
                (migration, executed_at, execution_time, status, description) 
                VALUES 
                (:migration, CURRENT_TIMESTAMP, :execution_time, 'success', :description)
            ");
            
            $stmt->execute([
                ':migration' => get_class($this),
                ':execution_time' => $executionTime,
                ':description' => $this->getDescription()
            ]);
            
            $this->db->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->db->rollBack();
            
            // Log failed migration
            try {
                $stmt = $this->db->prepare("
                    INSERT INTO `" . $this->getTableName('migrations') . "` 
                    (migration, executed_at, status, error_message, description) 
                    VALUES 
                    (:migration, CURRENT_TIMESTAMP, 'failed', :error, :description)
                ");
                
                $stmt->execute([
                    ':migration' => get_class($this),
                    ':error' => $e->getMessage(),
                    ':description' => $this->getDescription()
                ]);
            } catch (PDOException $logError) {
                error_log("Failed to log migration error: " . $logError->getMessage());
            }
            
            error_log("Migration Error: " . $e->getMessage());
            error_log("SQL: " . (!empty($sql) ? $sql : ''));
            return false;
        }
    }
    
    /**
     * Rollback the migration
     * 
     * @return bool Success status
     */
    public function rollback() {
        try {
            // Begin transaction
            $this->db->beginTransaction();
            
            // Execute rollback SQL
            $sql = $this->down();
            $this->db->exec($sql);
            
            // Remove migration log
            $stmt = $this->db->prepare("
                DELETE FROM `" . $this->getTableName('migrations') . "`
                WHERE migration = :migration
            ");
            $stmt->execute([
                ':migration' => get_class($this)
            ]);
            
            // Commit transaction
            $this->db->commit();
            return true;
            
        } catch (PDOException $e) {
            // Rollback on error
            $this->db->rollBack();
            error_log("Rollback Error: " . $e->getMessage());
            error_log("SQL: " . $sql);
            return false;
        }
    }
    
    /**
     * Migration up method - to be implemented by child classes
     * 
     * @return string SQL to run
     */
    abstract public function up();
    
    /**
     * Migration down method - to be implemented by child classes
     * 
     * @return string SQL to run
     */
    abstract public function down();
    
    /**
     * Get migration description - to be implemented by child classes
     * 
     * @return string Migration description
     */
    abstract public function getDescription();
} 