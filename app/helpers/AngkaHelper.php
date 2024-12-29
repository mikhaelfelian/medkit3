<?php
class Angka {
    /**
     * Format number with thousand separator
     * Example: 10.000.000
     */
    public static function format($angka) {
        if ($angka === null || $angka === '') {
            return '0';
        }
        return number_format((float)$angka, 0, ',', '.');
    }

    /**
     * Format as Rupiah with dash
     * Example: Rp. 10.000,-
     */
    public static function formatRupiahDash($angka) {
        if ($angka === null || $angka === '') {
            return 'Rp. 0,-';
        }
        return 'Rp. ' . number_format((float)$angka, 0, ',', '.') . ',-';
    }

    /**
     * Format as Rupiah with decimal
     * Example: Rp. 10.000,00
     */
    public static function formatRupiahDecimal($angka) {
        if ($angka === null || $angka === '') {
            return 'Rp. 0,00';
        }
        return 'Rp. ' . number_format((float)$angka, 2, ',', '.');
    }

    /**
     * Format as Rupiah (general)
     * Example: Rp. 10.000
     */
    public static function formatRupiah($angka) {
        if ($angka === null || $angka === '') {
            return 'Rp. 0';
        }
        return 'Rp. ' . number_format((float)$angka, 0, ',', '.');
    }

    /**
     * Clean number from any format
     */
    public static function cleanNumber($number) {
        if ($number === null || $number === '') {
            return 0;
        }
        // Remove all characters except digits and decimal point
        $clean = preg_replace('/[^0-9,.]/', '', $number);
        
        // Replace comma with dot for decimal
        $clean = str_replace(',', '.', $clean);
        
        // Convert to float or int
        return strpos($clean, '.') !== false ? (float)$clean : (int)$clean;
    }

    /**
     * Format number for database storage
     */
    public static function formatDB($number) {
        if ($number === null || $number === '') {
            return '0';
        }
        $angka = (float)$number;
        return str_replace(',', '.', str_replace('.', '', (string)$angka));
    }
} 