<?php
/**
 * Front Controller
 * Redirect all requests to public/index.php
 */

// Check if request is for a static file
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$publicPath = __DIR__ . '/public' . $uri;

if (file_exists($publicPath) && is_file($publicPath)) {
    // Serve static files directly
    return false;
} else {
    // Forward to public/index.php
    define('ROOT_PATH', __DIR__);
    require_once __DIR__ . '/public/index.php';
}
?>