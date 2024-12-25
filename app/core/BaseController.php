<?php

abstract class BaseController {
    protected function view($view, $data = []) {
        // Extract data to make variables available in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include APP_PATH . '/views/' . $view . '.php';
        
        // Get the view content
        $content = ob_get_clean();
        
        // Include the main layout with the view content
        include APP_PATH . '/views/layouts/main.php';
    }
} 