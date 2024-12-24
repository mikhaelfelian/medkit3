<?php
// Define root path if not defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Define other paths
define('APPPATH', ROOT_PATH . '/app/');
define('SYSPATH', ROOT_PATH . '/systems/');
define('PUBLIC_PATH', ROOT_PATH . '/public/');

// Load configuration first
require_once ROOT_PATH . '/config/config.php';

// Load core classes
require_once SYSPATH . 'Database.php';
require_once SYSPATH . 'BaseCore.php';
require_once SYSPATH . 'BaseSecurity.php';
require_once SYSPATH . 'routing/BaseRouting.php';
require_once SYSPATH . 'forms/BaseForm.php';
require_once SYSPATH . 'helpers/ViewHelper.php';

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