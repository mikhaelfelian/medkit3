<?php
// Load configuration first
require_once dirname(__DIR__) . '/config/config.php';

// Load core classes in correct order
require_once SYSTEM_PATH . '/Database.php';
require_once SYSTEM_PATH . '/models/BaseModel.php';
require_once SYSTEM_PATH . '/BaseCore.php';
require_once SYSTEM_PATH . '/BaseSecurity.php';
require_once SYSTEM_PATH . '/BaseAutoload.php';
require_once SYSTEM_PATH . '/routing/BaseRouting.php';
require_once SYSTEM_PATH . '/forms/BaseForm.php';
require_once SYSTEM_PATH . '/helpers/ViewHelper.php';

// Initialize autoloader
BaseAutoload::getInstance();

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