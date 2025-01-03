<?php
// Load configuration first
require_once dirname(__DIR__) . '/config/config.php';

// Load core classes in correct order
require_once SYSTEM_PATH . '/Database.php';
require_once SYSTEM_PATH . '/models/BaseModel.php';
require_once SYSTEM_PATH . '/BaseCore.php';
require_once SYSTEM_PATH . '/BaseSecurity.php';
require_once SYSTEM_PATH . '/libraries/Input.php';
require_once SYSTEM_PATH . '/BaseAutoload.php';
require_once SYSTEM_PATH . '/routing/BaseRouting.php';
require_once SYSTEM_PATH . '/forms/BaseForm.php';
require_once SYSTEM_PATH . '/helpers/ViewHelper.php';

try {
    // Initialize autoloader
    BaseAutoload::getInstance();

    // Initialize application
    new BaseCore();
    
} catch (Exception $e) {
    if (DEBUG_MODE) {
        echo "<div style='background: #fff; color: #721c24; padding: 20px; margin: 20px; border: 1px solid #f5c6cb; border-radius: 4px;'>";
        echo "<h3>Application Error</h3>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        if ($e->getPrevious()) {
            echo "<p><strong>Caused by:</strong> " . htmlspecialchars($e->getPrevious()->getMessage()) . "</p>";
        }
        echo "</div>";
    } else {
        error_log("Application Error: " . $e->getMessage());
        echo "<div style='background: #fff; color: #721c24; padding: 20px; margin: 20px; border: 1px solid #f5c6cb; border-radius: 4px;'>";
        echo "<h3>Application Error</h3>";
        echo "<p>An error occurred. Please try again later or contact support.</p>";
        echo "</div>";
    }
    exit;
}
?> 