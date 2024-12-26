<?php
class ViewHelper {
    private static $models = [];
    
    public static function loadModel($model) {
        $key = strtolower($model);
        
        if (!isset(self::$models[$key])) {
            $modelClass = $model . 'Model';
            $modelFile = APP_PATH . '/models/' . $modelClass . '.php';
            
            if (!file_exists($modelFile)) {
                throw new Exception("Model file not found: {$modelFile}");
            }
            
            require_once $modelFile;
            
            // Get database connection
            $conn = Database::getInstance()->getConnection();
            
            self::$models[$key] = new $modelClass($conn);
        }
        
        return self::$models[$key];
    }
} 