<?php
require_once 'config/config.php';
require_once 'systems/Database.php';
require_once 'systems/databases/MigrationRunner.php';

try {
    $runner = new MigrationRunner();
    $runner->run();
    echo "Migrations completed successfully\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}