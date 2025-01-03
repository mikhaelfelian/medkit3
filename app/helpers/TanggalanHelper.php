<?php
class TanggalanHelper {
    public static function formatID($date) {
        if (empty($date)) return '';
        return date('d/m/Y', strtotime($date));
    }
    
    public static function formatDB($date) {
        if (empty($date)) return null;
        $parts = explode('/', $date);
        if (count($parts) !== 3) return $date;
        return "{$parts[2]}-{$parts[1]}-{$parts[0]}";
    }
}