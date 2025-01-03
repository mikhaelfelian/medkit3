<?php
class FormHelper {
    public static function open($action = '', $method = 'POST', $attributes = []) {
        $html = '<form action="' . BaseRouting::url($action) . '" method="' . $method . '"';
        foreach ($attributes as $key => $value) {
            $html .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
        }
        return $html . '>';
    }
    
    public static function close() {
        return '</form>';
    }
    
    public static function csrf() {
        return BaseSecurity::getInstance()->getCSRFField();
    }
} 