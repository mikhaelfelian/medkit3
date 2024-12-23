<?php
// Temporarily enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define root path if not defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Load and initialize core
require_once ROOT_PATH . '/systems/BaseCore.php';
$app = new BaseCore();
?> 