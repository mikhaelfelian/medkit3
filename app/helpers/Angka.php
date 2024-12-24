<?php
class Angka {
    public static function formatRibuan($angka) {
        if (empty($angka)) return '0';
        return number_format($angka, 0, ',', '.');
    }
    
    public static function formatRupiah($angka) {
        if (empty($angka)) return '0,-';
        return number_format($angka, 0, ',', '.') . ',-';
    }
    
    public static function formatDecimal($angka) {
        if (empty($angka)) return '0,00';
        return number_format($angka, 2, ',', '.');
    }
    
    public static function unformat($angka) {
        if (empty($angka)) return 0;
        // Remove thousand separator and replace decimal comma with dot
        return (float) str_replace(['.', ','], ['', '.'], $angka);
    }
} 