<?php
class BaseSecurity {
    protected static $instance = null;
    protected $config;
    protected $token;
    
    private function __construct($config) {
        $this->config = $config;
        $this->initializeSecurity();
    }
    
    public static function getInstance($config = null) {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }
    
    protected function initializeSecurity() {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Set secure headers
        $this->setSecureHeaders();
        
        // Generate CSRF token if not exists
        if (!isset($_SESSION['csrf_token'])) {
            $this->regenerateToken();
        }
        
        // Validate request if needed
        if ($this->isPostRequest()) {
            $this->validateRequest();
        }
    }
    
    protected function setSecureHeaders() {
        // X-Frame-Options
        header('X-Frame-Options: SAMEORIGIN');
        
        // X-XSS-Protection
        header('X-XSS-Protection: 1; mode=block');
        
        // X-Content-Type-Options
        header('X-Content-Type-Options: nosniff');
        
        // Content-Security-Policy
        if ($this->config['enable_csp']) {
            header("Content-Security-Policy: {$this->config['csp_policy']}");
        }
        
        // Strict-Transport-Security
        if ($this->config['force_https']) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
        
        // Remove PHP version
        header_remove('X-Powered-By');
    }
    
    public function validateRequest() {
        // Validate CSRF token
        if ($this->config['csrf_protection']) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!$token || $token !== $_SESSION['csrf_token']) {
                $this->handleSecurityViolation('CSRF token validation failed');
            }
        }
        
        // Validate HTTP Origin
        if ($this->config['validate_origin']) {
            $origin = $_SERVER['HTTP_ORIGIN'] ?? null;
            if ($origin && !in_array($origin, $this->config['allowed_origins'])) {
                $this->handleSecurityViolation('Invalid origin');
            }
        }
        
        // Validate request method
        if (!in_array($_SERVER['REQUEST_METHOD'], $this->config['allowed_methods'])) {
            $this->handleSecurityViolation('Invalid request method');
        }
    }
    
    public function sanitizeInput($input, $type = 'text') {
        switch ($type) {
            case 'email':
                return filter_var($input, FILTER_SANITIZE_EMAIL);
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            case 'int':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case 'html':
                return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            case 'sql':
                return mysqli_real_escape_string($GLOBALS['conn'], $input);
            default:
                return strip_tags($input);
        }
    }
    
    public function regenerateToken() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    
    public function getToken() {
        return $_SESSION['csrf_token'] ?? $this->regenerateToken();
    }
    
    public function csrfField() {
        return '<input type="hidden" name="csrf_token" value="' . $this->getToken() . '">';
    }
    
    protected function handleSecurityViolation($message) {
        try {
            // Try to log the violation
            $this->logSecurityViolation($message);
        } catch (Exception $e) {
            // Log to PHP error log if security logging fails
            if (DEBUG_MODE) {
                error_log("Security violation logging failed: " . $e->getMessage());
            }
        }
        
        // Clear session if configured
        if ($this->config['clear_session_on_violation']) {
            session_destroy();
        }
        
        // Send response
        if (DEBUG_MODE) {
            die("Security Violation: " . $message);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            die('Access Denied');
        }
    }
    
    protected function logSecurityViolation($message) {
        try {
            $log_dir = ROOT_PATH . '/logs';
            $log_file = $log_dir . '/security.log';
            
            // Create logs directory if it doesn't exist
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0755, true);
            }
            
            // Create log file if it doesn't exist
            if (!file_exists($log_file)) {
                touch($log_file);
                chmod($log_file, 0644);
            }
            
            $timestamp = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $request_uri = $_SERVER['REQUEST_URI'];
            
            $log_message = sprintf(
                "[%s] IP: %s | UA: %s | URI: %s | Violation: %s\n",
                $timestamp,
                $ip,
                $user_agent,
                $request_uri,
                $message
            );
            
            if (is_writable($log_file)) {
                error_log($log_message, 3, $log_file);
            }
        } catch (Exception $e) {
            // Silently fail if logging is not possible
            if (DEBUG_MODE) {
                error_log("Security logging failed: " . $e->getMessage());
            }
        }
    }
    
    protected function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    public function validatePassword($password) {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($pattern, $password);
    }
    
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
?> 