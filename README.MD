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
ROOT_PATH/
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── helpers/
|   ├── libraries/
├── systems/
│   ├── controllers/
│   │   └── BaseController.php
│   ├── models/
│   │   └── BaseModel.php
│   ├── routing/
│   │   └── BaseRouting.php
│   └── helpers/
├── public/
│   └── assets/
│       ├── css/
│       ├── js/
│       └── vendor/
└── config/
```

## Configuration

Edit config/config.php to match your environment:

```php
define('DB_HOST', '<your-db-hosts>');
define('DB_NAME', '<your-db-name>');
define('DB_USER', '<your-db-user>');
define('DB_PASS', '<your-db-pass>');
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

### [1.0.8] - 2024-12-26
#### Added
- Enhanced error handling
  - Added custom 404 error page
  - Added error message display on 404 page
  - Added proper HTTP status codes
  - Added error logging for debugging
  - Added routing error messages
  - Added return to dashboard button

#### Changed
- Updated BaseRouting error handling
- Improved error message formatting
- Enhanced error page styling
- Updated asset path handling in error pages
- Standardized error display format

#### Fixed
- Fixed routing error handling
- Fixed missing action error display
- Fixed error page layout issues
- Fixed asset path references
- Fixed error message persistence

### [1.0.9] - 2024-12-26
#### Added
- Added show functionality for obat module:
  - Added show method in ObatController
  - Added show view with detail display
  - Added breadcrumb navigation
  - Added edit and back buttons
- Enhanced input handling:
  - Added Input library for secure input handling
  - Added input sanitization
  - Added SQL injection protection
  - Added XSS prevention
  - Added global input access
  - Added input helper methods

#### Changed
- Updated controllers to use Input library:
  - Refactored ObatController input handling
  - Refactored PasienController input handling
  - Refactored PengaturanController input handling
- Improved autoloading system:
  - Added core libraries loading
  - Added Input class to autoload
  - Enhanced library loading order

#### Fixed
- Fixed Input class loading issues
- Fixed global input access
- Fixed input sanitization
- Fixed security vulnerabilities
- Fixed autoloader configuration
- Fixed class loading order