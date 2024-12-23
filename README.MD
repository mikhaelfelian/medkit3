# MEDKIT3 - Medical Record System

A PHP-based HMVC framework designed for medical record systems. Built with modern PHP practices and a clean architecture.

## Features

- HMVC Architecture
- PDO Database Layer
- AdminLTE 3 Integration
- Security Features
- Form Validation
- Asset Management
- Session Handling
- Error Logging

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx
- mod_rewrite enabled

## Installation

1. Clone the repository
2. Import database.sql
3. Configure config/config.php
4. Set proper permissions
5. Access via web browser

## Directory Structure

```
medkit3/
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── helpers/
├── systems/
│   ├── controllers/
│   ├── models/
│   ├── routing/
│   └── helpers/
├── public/
│   └── assets/
└── config/
```

## Configuration

Edit config/config.php to match your environment:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_medkit3');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'http://localhost/medkit3');
```

## Usage

Access the application through:
http://localhost/medkit3

Default routes:
- Dashboard: /
- Patient Data: /pasien

## Security

- CSRF Protection
- XSS Prevention
- SQL Injection Protection
- Input Validation
- Secure Session Handling

## License

MIT License

## Created by:

Mikhael Felian Waskito
```

This README focuses on:
1. Actual implemented features
2. Real code examples
3. Existing file structure
4. Core functionalities
5. Installation steps
6. Framework requirements
7. Documentation access
8. Credits and licensing
9. URL routing
10. System configuration