<?php
class BaseController {
    protected $model;
    protected $security;
    protected $input;
    protected $viewHelper;
    protected $sections = [];
    protected $conn;

    public function __construct() {
        require_once SYSTEM_PATH . '/libraries/Input.php';
        require_once SYSTEM_PATH . '/libraries/Security.php';
        
        $this->conn = Database::getInstance()->getConnection();
        $this->security = new Security();
        $this->input = new Input();
        $this->viewHelper = new ViewHelper();
    }

    protected function view($view, $data = []) {
        // Load common helpers
        $this->loadHelper('Angka');
        $this->loadHelper('Notification');
        
        try {
            $controller = $this;
            
            // Make security instance available to views
            $security = $this->security;
            
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

    public static function handleException($e) {
        // Create logs directory if it doesn't exist
        $logDir = ROOT_PATH . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Log error to file
        $logFile = $logDir . '/error.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = sprintf(
            "[%s] %s in %s:%d\nStack trace:\n%s\n",
            $timestamp,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );
        error_log($logMessage, 3, $logFile);
        
        $data = [
            'error_message' => $e->getMessage()
        ];
        
        if (DEBUG_MODE) {
            $data['debug_message'] = $e->getMessage();
            $data['trace'] = $e->getTraceAsString();
        }
        
        // Set HTTP response code
        http_response_code(500);
        
        // Extract data for the view
        extract($data);
        
        // Render exception view
        require_once APP_PATH . '/views/errors/exception.php';
        exit;
    }

    protected function loadHelper($helper) {
        $helperName = ucfirst($helper) . 'Helper';
        
        // First try to load from app helpers
        $appHelperFile = APP_PATH . '/helpers/' . $helperName . '.php';
        if (file_exists($appHelperFile)) {
            require_once $appHelperFile;
            
            // Also load the backward compatibility class if it exists
            $compatFile = APP_PATH . '/helpers/' . ucfirst($helper) . '.php';
            if (file_exists($compatFile)) {
                require_once $compatFile;
            }
            return true;
        }
        
        // Then try system helpers
        $systemHelperFile = SYSTEM_PATH . '/helpers/' . $helperName . '.php';
        if (file_exists($systemHelperFile)) {
            require_once $systemHelperFile;
            return true;
        }
        
        return false;
    }

    protected function json($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
?> 