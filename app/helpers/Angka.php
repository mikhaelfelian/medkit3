<?php
require_once __DIR__ . '/AngkaHelper.php';

/**
 * @deprecated Use AngkaHelper instead
 */
class Angka extends AngkaHelper {
    // Backward compatibility methods
    public static function formatRupiah($number) {
        return parent::formatRupiah($number);
    }
    
    public static function formatNumber($number) {
        return parent::formatNumber($number);
    }
    
    public static function format($number) {
        return parent::formatNumber($number);
    }
    
    public static function unformat($number) {
        return parent::unformat($number);
    }
    
    // Add any other methods that might be used in old code
    public static function formatDB($number) {
        return parent::unformat($number);
    }
    
    public static function cleanNumber($number) {
        return parent::cleanNumber($number);
    }
}