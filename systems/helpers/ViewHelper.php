<?php
class ViewHelper {
    private static $models = [];
    
    public static function loadModel($model) {
        $key = strtolower($model);
        
        if (!isset(self::$models[$key])) {
            $modelClass = ucfirst($model) . 'Model';
            $modelPath = APP_PATH . '/models/' . $modelClass . '.php';
            
            if (file_exists($modelPath)) {
                require_once $modelPath;
                self::$models[$key] = new $modelClass();
            } else {
                throw new Exception("Model {$modelClass} not found");
            }
        }
        
        return self::$models[$key];
    }
} 