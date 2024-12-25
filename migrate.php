<?php
// First load config
require_once __DIR__ . '/config/config.php';

// Then load database
require_once __DIR__ . '/config/database.php';

// Finally load migration class
require_once __DIR__ . '/systems/databases/Migration.php';
require_once __DIR__ . '/systems/databases/BaseTables.php';

try {
    // Use existing database connection
    $db = $GLOBALS['conn'];
    
    echo "Starting migrations...\n";
    echo "==========================================\n";
    
    // Get all migration files
    $migrations = glob(__DIR__ . '/app/migrations/*.php');
    sort($migrations);
    
    // Move create_migrations.php to be first
    foreach ($migrations as $key => $file) {
        if (strpos($file, 'create_tbl_migrations.php') !== false) {
            // Remove and prepend to beginning
            $migration = array_splice($migrations, $key, 1)[0];
            array_unshift($migrations, $migration);
            break;
        }
    }
    
    // Track migration status
    $totalMigrations = count($migrations);
    $successCount = 0;
    $failedCount = 0;
    
    foreach ($migrations as $migration) {
        require_once $migration;
        
        // Get class name from filename
        $baseName = basename($migration, '.php');
        $className = 'Migration_' . $baseName;
        
        $migration = new $className($db);
        
        echo "\nMigrating: " . $migration->getDescription() . "\n";
        
        if ($migration->migrate()) {
            echo "✓ Migration successful\n";
            $successCount++;
        } else {
            echo "✗ Migration failed\n";
            $failedCount++;
        }
    }
    
    echo "\n==========================================\n";
    echo "Migration Summary:\n";
    echo "Total migrations: " . $totalMigrations . "\n";
    echo "Successful: " . $successCount . "\n";
    echo "Failed: " . $failedCount . "\n";
    echo "==========================================\n";
    
} catch (Exception $e) {
    echo "\n==========================================\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Migration process terminated.\n";
    echo "==========================================\n";
} 