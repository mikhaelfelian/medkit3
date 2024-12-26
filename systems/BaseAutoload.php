<?php
class BaseAutoload {
    private static $instance = null;
    private $models = [];
    private $config;
    
    private function __construct() {
        // Load autoload configuration
        $this->config = require ROOT_PATH . '/config/autoload.php';
        
        // Load core libraries first
        $this->loadCoreLibraries();
        
        // Load components
        $this->loadModels();
        $this->loadHelpers();
        $this->loadLibraries();
    }
    
    private function loadCoreLibraries() {
        $coreLibs = [
            'Input',
            'Database',
            'BaseSecurity'
        ];
        
        foreach ($coreLibs as $lib) {
            $libFile = SYSTEM_PATH . '/libraries/' . $lib . '.php';
            if (file_exists($libFile)) {
                require_once $libFile;
            }
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadModels() {
        if (!empty($this->config['models'])) {
            foreach ($this->config['models'] as $model) {
                $modelClass = ucfirst($model) . 'Model';
                $modelFile = APP_PATH . '/models/' . $modelClass . '.php';
                
                if (file_exists($modelFile)) {
                    require_once $modelFile;
                    $this->models[strtolower($model)] = new $modelClass(Database::getInstance()->getConnection());
                } else {
                    error_log("Model file not found: {$modelFile}");
                }
            }
        }
    }
    
    private function loadHelpers() {
        if (!empty($this->config['helpers'])) {
            foreach ($this->config['helpers'] as $helper) {
                $helperFile = SYSTEM_PATH . '/helpers/' . ucfirst($helper) . 'Helper.php';
                if (file_exists($helperFile)) {
                    require_once $helperFile;
                } else {
                    error_log("Helper file not found: {$helperFile}");
                }
            }
        }
    }
    
    private function loadLibraries() {
        if (!empty($this->config['libraries'])) {
            foreach ($this->config['libraries'] as $library) {
                $libraryFile = SYSTEM_PATH . '/libraries/' . ucfirst($library) . '.php';
                if (file_exists($libraryFile)) {
                    require_once $libraryFile;
                } else {
                    error_log("Library file not found: {$libraryFile}");
                }
            }
        }
    }
    
    public function getModel($model) {
        return $this->models[strtolower($model)] ?? null;
    }
    
    public function getModels() {
        return $this->models;
    }
} 