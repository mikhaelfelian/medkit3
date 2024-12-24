<?php

class BaseController {
    protected $model;
    protected $security;
    protected $form;
    protected $db;
    protected $models = [];
    
    public function __construct() {
        $this->security = BaseSecurity::getInstance();
        $this->form = BaseForm::getInstance();
        $this->db = Database::getInstance();
        
        // Load autoloaded models
        $autoload = BaseAutoload::getInstance();
        $this->models = $autoload->getModels();
    }
    
    protected function loadModel($model) {
        $modelKey = strtolower($model);
        
        // Try to get from autoloader first
        $autoload = BaseAutoload::getInstance();
        $loadedModel = $autoload->getModel($modelKey);
        if ($loadedModel) {
            return $loadedModel;
        }
        
        // Load manually if not autoloaded
        $modelClass = ucfirst($model) . 'Model';
        $modelPath = APP_PATH . '/models/' . $modelClass . '.php';
        
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $instance = new $modelClass($this->db->getConnection());
            return $instance;
        }
        
        throw new Exception("Model {$modelClass} not found");
    }
    
    protected function view($view, $data = []) {
        try {
            // Get global settings
            $settings = $this->models['pengaturan']->getSettings();
            $data['settings'] = $settings;
            
            // Start output buffering
            ob_start();
            
            // Extract data to local variables
            extract($data);
            
            // Load the view content
            require_once APPPATH . 'views/' . $view . '.php';
            
            // Get the view content
            $content = ob_get_clean();
            
            // Store content in data array
            $data['content'] = $content;
            
            // Start new buffer for layout
            ob_start();
            
            // Extract data again (now includes $content)
            extract($data);
            
            // Load the layout
            require_once APPPATH . 'views/layouts/default.php';
            
            // Return the complete page
            return ob_get_clean();
            
        } catch (Exception $e) {
            error_log("View Error: " . $e->getMessage());
            if (DEBUG_MODE) {
                die("View Error: " . $e->getMessage());
            }
            return '';
        }
    }
    
    // ... other methods ...
} 