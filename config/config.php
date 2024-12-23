<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_medkit3');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application Configuration
define('BASE_URL', 'http://localhost/medkit3');

// Define ROOT_PATH only if not already defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Debug Mode
define('DEBUG_MODE', true);

// Time Zone
date_default_timezone_set('Asia/Jakarta');

// Error Reporting
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define helper paths
define('HELPER_PATH', ROOT_PATH . '/systems/helpers');

// Load required files only if they exist
$required_files = [
    HELPER_PATH . '/functions.php',
    HELPER_PATH . '/Notification.php',
    HELPER_PATH . '/BaseSecurity.php',
    HELPER_PATH . '/Settings.php',
    ROOT_PATH . '/app/helpers/GenerateNoRM.php'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Required file not found: " . $file);
        if (DEBUG_MODE) {
            die("Required file not found: " . $file);
        }
    }
}
?> 