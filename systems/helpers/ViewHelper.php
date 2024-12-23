<?php
class ViewHelper {
    protected $layout = 'default';
    protected $sections = [];
    protected $currentSection = null;
    
    public function render($view, $data = [], $layout = null) {
        try {
            // Extract data to make it available in view
            extract($data);
            
            // Start output buffering
            ob_start();
            
            // Include the view file
            $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';
            if (!file_exists($viewFile)) {
                throw new Exception("View file not found: {$viewFile}");
            }
            
            require $viewFile;
            
            // Get the view content
            $content = ob_get_clean();
            
            // If layout is specified, wrap the content in it
            if ($layout !== false) {
                $layoutFile = ROOT_PATH . '/app/views/layouts/' . ($layout ?? $this->layout) . '.php';
                if (!file_exists($layoutFile)) {
                    throw new Exception("Layout file not found: {$layoutFile}");
                }
                
                // Start output buffering for layout
                ob_start();
                require $layoutFile;
                echo ob_get_clean();
                exit;
            }
            
            echo $content;
            exit;
            
        } catch (Exception $e) {
            echo "Error rendering view: " . $e->getMessage();
            exit;
        }
    }
    
    public function section($name) {
        $this->currentSection = $name;
        ob_start();
    }
    
    public function endSection() {
        if ($this->currentSection) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->currentSection = null;
        }
    }
    
    public function yield($section) {
        return $this->sections[$section] ?? '';
    }
    
    public function setLayout($layout) {
        $this->layout = $layout;
    }
} 