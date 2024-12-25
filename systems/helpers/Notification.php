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
    
    public static function warning($message) {
        $_SESSION['notification'] = [
            'type' => 'warning',
            'message' => $message
        ];
    }
    
    public static function info($message) {
        $_SESSION['notification'] = [
            'type' => 'info',
            'message' => $message
        ];
    }
    
    public static function get() {
        if (isset($_SESSION['notification'])) {
            $notification = $_SESSION['notification'];
            unset($_SESSION['notification']);
            return $notification;
        }
        return null;
    }
    
    public static function render() {
        return self::display();
    }
    
    public static function display() {
        $notification = self::get();
        if ($notification) {
            $type = $notification['type'];
            $message = $notification['message'];
            
            switch ($type) {
                case 'success':
                    $icon = 'fa-check';
                    $class = 'alert-success';
                    break;
                case 'error':
                    $icon = 'fa-ban';
                    $class = 'alert-danger';
                    break;
                case 'warning':
                    $icon = 'fa-exclamation-triangle';
                    $class = 'alert-warning';
                    break;
                default:
                    $icon = 'fa-info';
                    $class = 'alert-info';
            }
            
            echo "<div class='alert {$class} alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='icon fas {$icon}'></i> " . ucfirst($type) . "!</h5>
                    {$message}
                  </div>";
        }
    }
} 