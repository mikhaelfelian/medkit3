<?php
// Load configuration first
require_once __DIR__ . '/config/config.php';

// Load required files
require_once __DIR__ . '/systems/Database.php';
require_once __DIR__ . '/systems/databases/Migration.php';

try {
    // Get database connection
    $conn = new PDO(
        "mysql:host={$GLOBALS['db_config']['hostname']};dbname={$GLOBALS['db_config']['database']};charset={$GLOBALS['db_config']['charset']}",
        $GLOBALS['db_config']['username'],
        $GLOBALS['db_config']['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$GLOBALS['db_config']['charset']}"
        ]
    );

    // Get migration files
    $migrationFiles = glob(__DIR__ . '/app/migrations/*.php');
    
    foreach ($migrationFiles as $file) {
        require_once $file;
        
        // Get migration class name from filename
        $className = 'Migration_' . basename($file, '.php');
        
        if (class_exists($className)) {
            echo "Running migration: " . basename($file) . "\n";
            
            // Create migration instance with database connection
            $migration = new $className($conn);
            
            try {
                // Begin transaction
                $conn->beginTransaction();
                
                // Run migration
                $sql = $migration->up();
                $conn->exec($sql);
                
                // Commit transaction
                $conn->commit();
                
                echo "Migration successful\n";
            } catch (Exception $e) {
                // Rollback on error
                $conn->rollBack();
                echo "Migration failed: " . $e->getMessage() . "\n";
            }
        }
    }

    echo "All migrations completed\n";

} catch (Exception $e) {
    die("Migration Error: " . $e->getMessage() . "\n");
} 