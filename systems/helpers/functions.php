<?php
/**
 * Helper Functions
 */

if (!function_exists('dd')) {
    /**
     * Dump and die
     */
    function dd($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        die();
    }
}

if (!function_exists('e')) {
    /**
     * HTML Special Chars
     */
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('asset')) {
    /**
     * Get asset URL
     */
    function asset($path) {
        return BASE_URL . '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    /**
     * Get URL
     */
    function url($path = '') {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect
     */
    function redirect($url) {
        header('Location: ' . url($url));
        exit;
    }
} 