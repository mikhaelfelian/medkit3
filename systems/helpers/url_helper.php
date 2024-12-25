<?php
if (!function_exists('base_url')) {
    function base_url($uri = '') {
        return rtrim(BASE_URL, '/') . '/' . ltrim($uri, '/');
    }
}