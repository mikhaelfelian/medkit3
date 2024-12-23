<?php
class ViewHelper {
    public function render($view, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new Exception("View file not found: {$viewFile}");
        }
        include $viewFile;
        
        // Get the view content
        $content = ob_get_clean();
        
        // Include the layout
        $layoutFile = ROOT_PATH . '/app/views/layouts/main.php';
        if (!file_exists($layoutFile)) {
            throw new Exception("Layout file not found: {$layoutFile}");
        }
        include $layoutFile;
    }
} 