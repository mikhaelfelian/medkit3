<?php
// Environment Configuration
define('ENVIRONMENT', 'development'); // 'development' or 'production'

// Database Configuration
$db_config = [
    'development' => [
        'hostname' => 'localhost',
        'database' => 'db_medkit3',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    ],
    'production' => [
        'hostname' => 'localhost',
        'database' => 'db_medkit3',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    ]
];

// Application Configuration
$app_config = [
    'development' => [
        'base_url' => 'http://localhost/medkit3',
        'debug_mode' => true,
        'timezone' => 'Asia/Jakarta',
        'encryption_key' => 'your-32-char-key',
        'encryption_method' => 'AES-256-CBC'
    ],
    'production' => [
        'base_url' => 'https://your-domain.com',
        'debug_mode' => false,
        'timezone' => 'Asia/Jakarta',
        'encryption_key' => 'production-32-char-key',
        'encryption_method' => 'AES-256-CBC'
    ]
];

// Load environment-specific configuration
$current_config = $app_config[ENVIRONMENT];

// Define paths
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__));
defined('APP_PATH') or define('APP_PATH', ROOT_PATH . '/app');
defined('SYSTEM_PATH') or define('SYSTEM_PATH', ROOT_PATH . '/systems');
defined('PUBLIC_PATH') or define('PUBLIC_PATH', ROOT_PATH . '/public');
defined('BASE_URL') or define('BASE_URL', $current_config['base_url']);
defined('DEBUG_MODE') or define('DEBUG_MODE', $current_config['debug_mode']);
define('APP_NAME', 'MEDKIT3');
define('APP_VERSION', '1.0.0');

// Set timezone
date_default_timezone_set($current_config['timezone']);

// Make configurations globally available
$GLOBALS['app_config'] = $current_config;
$GLOBALS['db_config'] = $db_config[ENVIRONMENT];
?> 