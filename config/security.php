<?php
// Security Configuration
return [
    // CSRF Protection
    'csrf_protection' => true,
    'csrf_token_name' => 'csrf_token',
    'csrf_expiration' => 7200, // 2 hours
    
    // Content Security Policy
    'enable_csp' => true,
    'csp_policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:",
    
    // HTTPS
    'force_https' => false, // Set to true in production
    
    // Session Security
    'session_secure' => true,
    'session_httponly' => true,
    'session_samesite' => 'Lax',
    
    // Request Validation
    'validate_origin' => true,
    'allowed_origins' => [
        'http://localhost',
        'http://localhost:8080',
        'http://your-production-domain.com'
    ],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
    
    // Security Response
    'clear_session_on_violation' => true,
    'log_violations' => true,
    
    // Password Policy
    'password_min_length' => 8,
    'password_require_special' => true,
    'password_require_number' => true,
    'password_require_uppercase' => true,
    'password_require_lowercase' => true,
    
    // Rate Limiting
    'enable_rate_limiting' => true,
    'rate_limit_requests' => 100,
    'rate_limit_minutes' => 60,
    
    // File Upload Security
    'allowed_file_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf'
    ],
    'max_file_size' => 5242880, // 5MB
    
    // SQL Injection Prevention
    'auto_escape_sql' => true,
    
    // XSS Prevention
    'auto_escape_html' => true,
    
    // Logging Configuration
    'logging' => [
        'enabled' => true,
        'path' => ROOT_PATH . '/logs/security.log',
        'permissions' => 0644,
        'max_size' => 10485760, // 10MB
    ],
];
?> 