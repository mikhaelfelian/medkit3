<?php
class BaseController {
    protected $model;
    protected $security;
    protected $input;
    protected $viewHelper;
    protected $sections = [];

    public function __construct() {
        require_once SYSTEM_PATH . '/libraries/Input.php';
        require_once SYSTEM_PATH . '/libraries/Security.php';
        
        $this->security = new Security();
        $this->input = new Input();
        $this->viewHelper = new ViewHelper();
    }

    protected function view($view, $data = []) {
        try {
            $controller = $this;
            
            extract($data);
            ob_start();
            
            $viewPath = APP_PATH . '/views/' . $view . '.php';
            if (!file_exists($viewPath)) {
                throw new Exception("View file not found: {$viewPath}");
            }
            
            require $viewPath;
            $content = ob_get_clean();
            
            ob_start();
            require APP_PATH . '/views/layouts/main.php';
            $output = ob_get_clean();
            
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            
            echo $output;
            exit;
            
        } catch (Exception $e) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            error_log("View Error: " . $e->getMessage());
            throw $e;
        }
    }

    protected function redirect($url) {
        header('Location: ' . BaseRouting::url($url));
        exit;
    }

    protected function loadModel($model) {
        return ViewHelper::loadModel($model);
    }

    protected function section($name, $content) {
        if (!isset($this->sections[$name])) {
            $this->sections[$name] = [];
        }
        $this->sections[$name][] = $content;
    }

    protected function getSection($name) {
        if (!isset($this->sections[$name])) {
            return '';
        }
        return implode("\n", $this->sections[$name]);
    }
}
?> 