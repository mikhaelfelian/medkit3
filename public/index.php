<?php
// Define root path if not defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Load configuration first
require_once ROOT_PATH . '/config/config.php';

// Load core classes
require_once ROOT_PATH . '/systems/Database.php';
require_once ROOT_PATH . '/systems/BaseCore.php';
require_once ROOT_PATH . '/systems/BaseSecurity.php';
require_once ROOT_PATH . '/systems/routing/BaseRouting.php';
require_once ROOT_PATH . '/systems/forms/BaseForm.php';

// Initialize application
try {
    new BaseCore();
} catch (Exception $e) {
    if (DEBUG_MODE) {
        die("Application Error: " . $e->getMessage());
    } else {
        error_log("Application Error: " . $e->getMessage());
        die("An error occurred. Please try again later.");
    }
}
?> 