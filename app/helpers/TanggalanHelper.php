<?php
class Tanggalan {
    private static $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    private static $bulanPendek = [
        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];
    
    public static function formatPendek($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        return date('d/m/y', $timestamp);
    }
    
    public static function formatPanjang($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        return date('d/m/Y', $timestamp);
    }
    
    public static function formatBulanPendek($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        $d = date('d', $timestamp);
        $m = self::$bulanPendek[date('n', $timestamp)];
        $y = date('Y', $timestamp);
        return "$d $m $y";
    }
    
    public static function formatBulanPanjang($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        $d = date('d', $timestamp);
        $m = self::$bulan[date('n', $timestamp)];
        $y = date('Y', $timestamp);
        return "$d $m $y";
    }
    
    public static function formatStripPendek($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        return date('d-m-y', $timestamp);
    }
    
    public static function formatStripPanjang($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        return date('d-m-Y', $timestamp);
    }
    public static function formatDB($date) {
        if (empty($date)) return '';
        $timestamp = strtotime($date);
        return date('Y-m-d', $timestamp);
    }
}