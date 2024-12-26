<?php
class BaseController {
    protected $model;
    protected $security;
    protected $input;
    protected $viewHelper;

    public function __construct() {
        require_once SYSTEM_PATH . '/libraries/Input.php';
        require_once SYSTEM_PATH . '/libraries/Security.php';
        
        $this->security = new Security();
        $this->input = new Input();
        $this->viewHelper = new ViewHelper();
    }

    protected function view($view, $data = []) {
        try {
            extract($data);
            ob_start();
            
            $viewPath = APP_PATH . '/views/' . $view . '.php';
            if (!file_exists($viewPath)) {
                throw new Exception("View file not found: {$viewPath}");
            }
            
            include $viewPath;
            $content = ob_get_clean();
            
            ob_start();
            include APP_PATH . '/views/layouts/main.php';
            return ob_get_clean();
            
        } catch (Exception $e) {
            ob_end_clean();
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
}
?> 