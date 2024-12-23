<?php
try {
    $db_config = $GLOBALS['db_config'][ENVIRONMENT];
    
    $conn = new PDO(
        "mysql:host={$db_config['hostname']};dbname={$db_config['database']};charset={$db_config['charset']}",
        $db_config['username'],
        $db_config['password']
    );
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
    $GLOBALS['conn'] = $conn;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 