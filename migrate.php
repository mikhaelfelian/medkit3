<?php
require_once 'config/config.php';
require_once 'systems/Database.php';

class Migrate {
    private $conn;
    private $migrations = [];
    
    public function __construct() {
        try {
            $this->conn = Database::getInstance()->getConnection();
            $this->createMigrationsTable();
            $this->loadMigrations();
        } catch (Exception $e) {
            die("Migration Error: " . $e->getMessage() . "\n");
        }
    }
    
    private function createMigrationsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->conn->exec($sql);
    }
    
    private function loadMigrations() {
        $path = __DIR__ . '/databases/migrations/';
        $files = scandir($path);
        
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $this->migrations[] = $file;
            }
        }
    }
    
    public function run() {
        foreach ($this->migrations as $migration) {
            if (!$this->hasBeenExecuted($migration)) {
                $this->executeMigration($migration);
            }
        }
        echo "Migrations completed successfully.\n";
    }
    
    private function hasBeenExecuted($migration) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
        $stmt->execute([$migration]);
        return (bool) $stmt->fetchColumn();
    }
    
    private function executeMigration($migration) {
        try {
            $sql = file_get_contents(__DIR__ . '/databases/migrations/' . $migration);
            
            // Execute migration
            $this->conn->exec($sql);
            
            // Record successful migration
            $stmt = $this->conn->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->execute([$migration]);
            
            echo "Executed migration: {$migration}\n";
            
        } catch (Exception $e) {
            die("Error executing migration {$migration}: " . $e->getMessage() . "\n");
        }
    }
}

// Run migrations
$migrate = new Migrate();
$migrate->run();