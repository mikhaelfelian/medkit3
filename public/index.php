<?php
// Define root path if not defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Enable error reporting in development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load and initialize core
require_once ROOT_PATH . '/systems/BaseCore.php';

// Initialize application
try {
    new BaseCore();
} catch (Exception $e) {
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        die("Application Error: " . $e->getMessage());
    } else {
        error_log("Application Error: " . $e->getMessage());
        die("An error occurred. Please try again later.");
    }
}
?> 