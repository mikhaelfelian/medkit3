<?php
class Angka {
    /**
     * Format number with thousand separator
     * Example: 10.000.000
     */
    public static function format($angka) {
        return number_format($angka, 0, ',', '.');
    }

    /**
     * Format as Rupiah with dash
     * Example: Rp. 10.000,-
     */
    public static function formatRupiahDash($angka) {
        return 'Rp. ' . number_format($angka, 0, ',', '.') . ',-';
    }

    /**
     * Format as Rupiah with decimal
     * Example: Rp. 10.000,00
     */
    public static function formatRupiahDecimal($angka) {
        return 'Rp. ' . number_format($angka, 2, ',', '.');
    }

    /**
     * Format as Rupiah (general)
     * Example: Rp. 10.000
     */
    public static function formatRupiah($angka) {
        return 'Rp. ' . number_format($angka, 0, ',', '.');
    }

    /**
     * Clean number from any format
     */
    public static function cleanNumber($number) {
        // Remove all characters except digits and decimal point
        $clean = preg_replace('/[^0-9,.]/', '', $number);
        
        // Replace comma with dot for decimal
        $clean = str_replace(',', '.', $clean);
        
        // Convert to float or int
        return strpos($clean, '.') !== false ? (float)$clean : (int)$clean;
    }

    public static function formatDB($number) {
        $angka  = (float) $number;
        $string = str_replace(',','.', str_replace('.','', $number));
        return $string;
    }

} 