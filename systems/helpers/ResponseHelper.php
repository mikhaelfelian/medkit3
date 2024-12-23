<?php
class ResponseHelper {
    public function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    public function redirect($url, $statusCode = 302) {
        header('Location: ' . BASE_URL . '/' . trim($url, '/'), true, $statusCode);
        exit;
    }
} 