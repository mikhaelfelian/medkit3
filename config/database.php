<?php
// Make sure config is loaded first
if (!defined('ENVIRONMENT')) {
    require_once __DIR__ . '/config.php';
}

try {
    $db_config = $GLOBALS['db_config'];

    $dsn = sprintf(
        "mysql:host=%s;dbname=%s;charset=%s",
        $db_config['hostname'],
        $db_config['database'],
        $db_config['charset']
    );

    $conn = new PDO(
        $dsn,
        $db_config['username'],
        $db_config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db_config['charset']}"
        ]
    );

    $GLOBALS['conn'] = $conn;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?> 