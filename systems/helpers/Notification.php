<?php
class Notification {
    public static function success($message) {
        $_SESSION['notification'] = [
            'type' => 'success',
            'message' => $message
        ];
    }
    
    public static function error($message) {
        $_SESSION['notification'] = [
            'type' => 'error',
            'message' => $message
        ];
    }
    
    public static function render() {
        if (isset($_SESSION['notification'])) {
            $notification = $_SESSION['notification'];
            unset($_SESSION['notification']);
            
            $type = $notification['type'] === 'success' ? 'success' : 'danger';
            $icon = $notification['type'] === 'success' ? 'check' : 'ban';
            
            return '<div class="alert alert-' . $type . ' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-' . $icon . '"></i> ' . 
                ($notification['type'] === 'success' ? 'Success!' : 'Error!') . '</h5>
                ' . $notification['message'] . '
            </div>';
        }
        return '';
    }
} 