<?php
class BaseNotification {
    protected static $instance = null;
    protected $sessionKey = 'flash_notifications';
    
    protected function __construct() {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize flash data
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Add success notification
     */
    public function success($message) {
        $this->add('success', $message);
    }
    
    /**
     * Add error notification
     */
    public function error($message) {
        $this->add('danger', $message);
    }
    
    /**
     * Add warning notification
     */
    public function warning($message) {
        $this->add('warning', $message);
    }
    
    /**
     * Add info notification
     */
    public function info($message) {
        $this->add('info', $message);
    }
    
    /**
     * Add notification
     */
    protected function add($type, $message) {
        $_SESSION[$this->sessionKey][] = [
            'type' => $type,
            'message' => $message,
            'icon' => $this->getIcon($type)
        ];
    }
    
    /**
     * Get icon for notification type
     */
    protected function getIcon($type) {
        switch ($type) {
            case 'success':
                return 'fas fa-check';
            case 'danger':
                return 'fas fa-ban';
            case 'warning':
                return 'fas fa-exclamation-triangle';
            case 'info':
                return 'fas fa-info';
            default:
                return 'fas fa-bell';
        }
    }
    
    /**
     * Get all notifications and clear them
     */
    public function all() {
        $notifications = $_SESSION[$this->sessionKey] ?? [];
        $this->clear();
        return $notifications;
    }
    
    /**
     * Check if has any notifications
     */
    public function has() {
        return !empty($_SESSION[$this->sessionKey]);
    }
    
    /**
     * Clear all notifications
     */
    public function clear() {
        $_SESSION[$this->sessionKey] = [];
    }
    
    /**
     * Render notifications HTML
     */
    public function render() {
        $notifications = $this->all();
        if (empty($notifications)) {
            return '';
        }
        
        $html = '';
        foreach ($notifications as $notification) {
            $html .= sprintf(
                '<div class="alert alert-%s alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="%s"></i> %s</h5>
                    %s
                </div>',
                $notification['type'],
                $notification['icon'],
                ucfirst($notification['type']),
                $notification['message']
            );
        }
        
        return $html;
    }
}
?> 