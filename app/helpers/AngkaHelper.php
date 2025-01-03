<?php
class AngkaHelper {
    public static function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
    
    public static function formatNumber($angka) {
        return number_format($angka, 0, ',', '.');
    }
    
    public static function unformat($angka) {
        return (float)str_replace(['Rp ', '.', ','], ['', '', '.'], $angka);
    }
    
    public static function format($angka) {
        return self::formatNumber($angka);
    }
    
    public static function formatDB($angka) {
        return self::unformat($angka);
    }
    
    public static function cleanNumber($angka) {
        if (empty($angka)) return 0;
        // Remove any non-numeric characters except decimal point and minus
        $clean = preg_replace('/[^0-9\-\.]/', '', $angka);
        return (float)$clean;
    }
} 