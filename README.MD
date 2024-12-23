# NUSANTARA - HMVC Framework 1.0 Beta

A lightweight HMVC PHP framework with AdminLTE integration for healthcare information systems.

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx
- mod_rewrite enabled

## Installation

1. Clone repository:
```

2. Database configuration:
```php
// config/config.php
$db_config = [
    'development' => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'your_database'
    ]
];
```

## Framework Structure

```plaintext:app/README.MD
project/
├── app/
│   ├── controllers/
│   │   ├── PasienController.php    # Patient management
│   │   └── PengaturanController.php # System settings
│   ├── migrations/
│   │   ├── users-migration.php     # User authentication
│   │   └── pengaturan-migration.php # System settings
│   └── views/
│       └── layouts/
│           └── main.php            # AdminLTE layout
├── public/
│   └── .htaccess                   # URL routing
├── systems/
│   └── BaseForm.php               # Form handling
└── documentation/
    └── index.html                 # Framework docs
```

## Core Features

### 1. System Settings
```php
// app/migrations/20240315123457-pengaturan-migration.php
$tables->create('pengaturan', function($table) {
    $table->increments('id');
    $table->string('judul_app', 100)->notNull();
    $table->string('logo', 255)->nullable();
    $table->string('favicon', 255)->nullable();
    $table->timestamps();
});
```

### 2. Patient Management
```php
// app/controllers/PasienController.php
class PasienController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->loadModel('PasienModel');
    }

    public function index() {
        return $this->view('pasien/index', [
            'title' => 'Data Pasien'
        ]);
    }
}
```

### 3. Form Handling
- CSRF Protection
- Input Validation
- File Upload Management
- XSS Prevention

### 4. URL Routing
```apache
# public/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

## Documentation
Access framework documentation at:
```
http://your-site/documentation
```

## Credits

Created by:
- Mikhael Felian Waskito
- Artificial Intelligence

Semarang, 23 December 2024

## License

MIT License
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