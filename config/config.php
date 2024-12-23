<?php
// Skip if ROOT_PATH is already defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(dirname(__FILE__)));
}

// Define environment
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

// Define base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$folder_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = rtrim($folder_path, '/');
if ($base_path == '\\' || $base_path == '/') {
    $base_path = '';
}
define('BASE_URL', $protocol . '://' . $host . $base_path);

// Database Configuration
$db_config = [
    'development' => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'db_medkit3',
        'charset'  => 'utf8',
        'dbcollat' => 'utf8_general_ci'
    ],
    'production' => [
        'hostname' => 'localhost',
        'username' => 'prod_user',
        'password' => 'prod_password',
        'database' => 'db_medkit3',
        'charset'  => 'utf8',
        'dbcollat' => 'utf8_general_ci'
    ]
];

// Application Configuration
$config = [
    'development' => [
        'app_name' => 'Sistem Pasien Dev',
        'app_version' => '1.0.0',
        'timezone' => 'Asia/Jakarta',
        'language' => 'id',
        'debug_mode' => false,
        'encryption_key' => '12345678901234567890123456789012',
        'encryption_method' => 'AES-256-CBC',
        'db_prefix' => 'tbl_',  // Table prefix for development
        'db_charset' => 'utf8mb4',
        'db_collation' => 'utf8mb4_unicode_ci'
    ],
    'production' => [
        'app_name' => 'Sistem Pasien',
        'app_version' => '1.0.0',
        'timezone' => 'Asia/Jakarta',
        'language' => 'id',
        'debug_mode' => false,
        'encryption_key' => getenv('APP_ENCRYPTION_KEY'),
        'encryption_method' => 'AES-256-CBC',
        'db_prefix' => 'tbl_',  // Table prefix for production
        'db_charset' => 'utf8mb4',
        'db_collation' => 'utf8mb4_unicode_ci'
    ]
];

// Set global configurations
$GLOBALS['db_config'] = $db_config;
$GLOBALS['app_config'] = $config[ENVIRONMENT];

// Define constants
define('APP_NAME', $config[ENVIRONMENT]['app_name']);
define('APP_VERSION', $config[ENVIRONMENT]['app_version']);
define('DEBUG_MODE', $config[ENVIRONMENT]['debug_mode']);

// Set timezone
date_default_timezone_set($config[ENVIRONMENT]['timezone']);

// Autoloader function
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'Model') !== false) {
        $file = ROOT_PATH . '/app/models/' . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});
?> 