# MEDKIT3 - Medical Record System

A PHP-based HMVC framework designed for medical record systems. Built with modern PHP practices and a clean architecture.

## About NUSANTARA - HMVC 1.0 Beta

NUSANTARA - HMVC is a lightweight PHP framework that embodies the spirit of Indonesian archipelago (Nusantara). Just as Nusantara represents the unity of diverse islands, this framework unifies various components into a cohesive system while maintaining their independence.

The name "NUSANTARA" comes from two Sanskrit words:
- **Nusa**: Island
- **Antara**: Between/Across

This reflects our framework's philosophy:
- **Modularity**: Like islands connected by sea
- **Flexibility**: Adaptable to different needs
- **Independence**: Each component can stand alone
- **Unity**: Working together as one system

Version 1.0 Beta represents our commitment to continuous improvement and community feedback.

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
Semarang, 23 December 2024
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
```

## Changelog
```
### [1.0.0] - 2024-03-11

#### Added
- Created base MVC structure
- Added BaseCore for application initialization
- Added BaseController for handling views
- Added BaseRouting for URL handling
- Added BaseModel for database operations
- Added layout system with AdminLTE 3 theme
- Added helper functions (url_helper, Notification)
- Added session handling
- Added class autoloader
- Added database configuration
- Added template system with layouts
  - header.php
  - footer.php
  - navbar.php
  - sidebar.php
  - main.php
- Added Master Data menu structure
  - Data Obat
    - CRUD operations
    - Stock management
    - Price management
    - Code generation
  - Data Pasien
    - CRUD operations
    - Patient information
    - Contact details
    - Address management
    - Code generation
- Added Pengaturan menu
  - Aplikasi
    - App settings
    - Theme configuration
    - Logo management
    - System preferences
- Added notification system
- Added migration system
- Added tbl_pengaturans table
- Added tbl_m_items table
- Added tbl_m_pasiens table
- Added PengaturanModel and Controller
- Added ObatModel and Controller
- Added PasienModel and Controller
- Added ViewHelper for model loading in views
- Added CSRF protection
- Added form validation
- Added error handling
- Added search functionality
- Added pagination system

### [1.0.0] - 2024-12-20
#### Changed
- Updated asset paths to use BaseRouting::asset()
- Improved error handling
- Enhanced template structure
- Optimized autoloader
- Refined database queries
- Enhanced security measures
- Improved form handling
- Updated table structures
- Enhanced code organization
- Standardized coding patterns

### [1.0.0] - 2024-12-25
#### Fixed
- Fixed notification rendering
- Fixed session initialization
- Fixed asset path handling
- Fixed layout includes
- Fixed CSRF validation
- Fixed form submissions
- Fixed data validation
- Fixed search functionality
- Fixed pagination display
- Fixed code generation