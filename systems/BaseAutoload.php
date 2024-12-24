<?php
class BaseAutoload {
    private static $instance = null;
    private $models = [];
    private $helpers = [];
    private $libraries = [];
    private $config;
    
    private function __construct() {
        // Load autoload configuration
        $this->config = require ROOT_PATH . '/config/autoload.php';
        
        // Initialize autoloaded items
        $this->loadModels();
        $this->loadHelpers();
        $this->loadLibraries();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function loadModels() {
        if (!empty($this->config['models'])) {
            foreach ($this->config['models'] as $model) {
                $modelClass = ucfirst($model) . 'Model';
                $modelPath = APP_PATH . '/models/' . $modelClass . '.php';
                
                if (file_exists($modelPath)) {
                    require_once $modelPath;
                    $this->models[$model] = new $modelClass(Database::getInstance()->getConnection());
                } else {
                    error_log("Warning: Model not found - {$modelPath}");
                }
            }
        }
        return $this->models;
    }
    
    public function loadHelpers() {
        if (!empty($this->config['helpers'])) {
            foreach ($this->config['helpers'] as $helper) {
                $helperPath = SYSTEM_PATH . '/helpers/' . $helper . '_helper.php';
                
                if (file_exists($helperPath)) {
                    require_once $helperPath;
                } else {
                    error_log("Warning: Helper not found - {$helperPath}");
                }
            }
        }
    }
    
    public function loadLibraries() {
        if (!empty($this->config['libraries'])) {
            foreach ($this->config['libraries'] as $library) {
                $libraryPath = SYSTEM_PATH . '/libraries/' . $library . '.php';
                
                if (file_exists($libraryPath)) {
                    require_once $libraryPath;
                } else {
                    error_log("Warning: Library not found - {$libraryPath}");
                }
            }
        }
    }
    
    public function getModel($name) {
        return $this->models[$name] ?? null;
    }
    
    public function getModels() {
        return $this->models;
    }
} 