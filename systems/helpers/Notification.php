<?php
require_once APP_PATH . '/helpers/ToastrHelper.php';

/**
 * @deprecated Use ToastrHelper instead
 */
class Notification extends ToastrHelper {
    // This class exists only for backward compatibility
    
    // Override render method to maintain backward compatibility
    public static function render() {
        if (self::has()) {
            $html = '<script>';
            $html .= 'toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };';
            
            foreach (self::get() as $notification) {
                $type = $notification['type'];
                $message = addslashes($notification['message']);
                $title = addslashes($notification['title'] ?? '');
                
                $html .= "toastr['{$type}']('{$message}', '{$title}');";
            }
            
            $html .= '</script>';
            echo $html;
        }
    }
} 