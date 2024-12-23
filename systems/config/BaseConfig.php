<?php
class BaseConfig {
    protected static $environment;
    protected static $config;
    protected static $db_config;

    public static function init($environment, $config, $db_config) {
        self::$environment = $environment;
        self::$config = $config;
        self::$db_config = $db_config;

        // Set error reporting based on environment
        self::setErrorReporting();

        // Set timezone
        date_default_timezone_set(self::getConfig('timezone'));

        // Define constants first
        define('BASE_URL', self::getBaseUrl());
        define('APP_NAME', self::getConfig('app_name'));
        define('APP_VERSION', self::getConfig('app_version'));
        define('DEBUG_MODE', self::getConfig('debug_mode'));

        // Set error handler for production
        if (self::isProduction()) {
            set_error_handler([self::class, 'customErrorHandler']);
        }

        // Set database configuration globally
        $GLOBALS['db_config'] = self::getDatabaseConfig();
    }

    public static function setErrorReporting() {
        switch (self::$environment) {
            case 'development':
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                break;
            
            case 'production':
                error_reporting(0);
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);
                break;

            default:
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                echo 'Environment is not properly set.';
                exit(1);
        }
    }

    public static function customErrorHandler($errno, $errstr, $errfile, $errline) {
        // Create logs directory if it doesn't exist
        if (!is_dir('logs')) {
            mkdir('logs', 0777, true);
        }

        // Log error to file
        $error_log = "logs/error_" . date('Y-m-d') . ".log";
        $timestamp = date('Y-m-d H:i:s');
        $message = "$timestamp - Error [$errno]: $errstr in $errfile on line $errline\n";
        error_log($message, 3, $error_log);

        // Show generic error message to user
        if (self::isDebugMode()) {
            echo "An error occurred. Please check the error log for details.";
        }
        return true;
    }

    public static function debug($data) {
        if (self::isDebugMode()) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }

    public static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $folder_path = dirname($_SERVER['SCRIPT_NAME']);
        $base_path = rtrim($folder_path, '/');

        if ($base_path == '\\' || $base_path == '/') {
            $base_path = '';
        }

        return $protocol . '://' . $host . $base_path;
    }

    public static function getConfig($key = null) {
        $current_config = self::$config[self::$environment];
        return $key ? ($current_config[$key] ?? null) : $current_config;
    }

    public static function getDatabaseConfig() {
        return self::$db_config[self::$environment];
    }

    public static function isDebugMode() {
        return self::getConfig('debug_mode') === true;
    }

    public static function isProduction() {
        return self::$environment === 'production';
    }

    public static function isDevelopment() {
        return self::$environment === 'development';
    }
}
?> 