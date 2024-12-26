<?php
class Security {
    public function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
    }

    public function getCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}