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
```bash
git clone https://github.com/mikhaelfelian/medkit3.git
cd medkit3
```

2. Create and setup the database
```bash
# Create MySQL database
mysql -u root -p
CREATE DATABASE medkit3;
exit;

# Import initial schema
mysql -u root -p medkit3 < databases/migrations/schema.sql

# Run migrations
php systems/cli/migrate.php
```

3. Configure your application
```bash
# Copy sample config file
cp config/config.sample.php config/config.php

# Edit configuration with your settings
nano config/config.php
```

4. Set proper permissions
```bash
chmod 755 -R ./
chmod 777 -R ./public/uploads/
chmod 777 -R ./public/assets/cache/
```

5. Access via web browser
```
http://localhost/medkit3/
```

## Directory Structure

```
medkit3/
├── app/
│   ├── controllers/    # Application-specific controllers
│   ├── models/         # Database models and business logic
│   ├── views/          # Template files and UI components
│   ├── helpers/        # Utility functions and helpers
│   └── modules/        # HMVC modules
├── systems/
│   ├── core/          # Framework core components
│   ├── controllers/   # Base controller classes
│   ├── models/        # Base model classes
│   ���── routing/       # URL routing and dispatching
│   ├── database/      # Database abstraction layer
│   ├── security/      # Security components
│   └── helpers/       # System-wide helper functions
├── public/
│   ├── assets/        # CSS, JavaScript, and images
│   ├── uploads/       # User uploaded files
│   └── index.php      # Entry point
├── config/
│   ├── config.php     # Main configuration
│   ├── database.php   # Database settings
│   ├── routes.php     # Custom routes
│   └── autoload.php   # Autoloader configuration
└── vendor/            # Third-party dependencies
```

## Configuration

Edit config/config.php to match your environment:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your-db-name');
define('DB_USER', 'your-db-username');
define('DB_PASS', 'your-db-password');
define('BASE_URL', 'your-url-app');
```

## Usage
On demo program, Access the application through:
https://medkit3.tigerasoft.com

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
## Changelog:

### v1.0.0 (2024-12-23)
- Initial release
- Core features implementation:
  - Patient data management
  - Dashboard analytics
  - User authentication
  - Database integration
  - Security implementations

### v1.0.1 (2024-12-23)
- Added CSRF protection
- Enhanced XSS prevention
- Improved SQL injection protection
- Implemented secure session handling
- Added input validation
- Documentation updates

### v1.0.2 (2024-03-19)
- Enhanced file upload functionality:
  - Added automatic upload directory creation
  - Fixed file path handling in database storage
  - Updated file access permissions via .htaccess
  - Implemented secure file upload directory structure
  - Standardized upload paths to use public/file/app/

### v1.0.3 (2024-12-25)
- Improved application settings:
  - Added logo and favicon management
  - Enhanced file type validation for uploads
  - Implemented file cleanup on update
  - Added support for JPG, JPEG, PNG for logo
  - Added support for ICO, PNG for favicon
  - Updated layout to use dynamic logo/favicon
  - Improved file access security
  - Added fallback to default theme assets

### v1.0.4 (2024-12-25)
- Added Indonesian date formatting:
  - Added Tanggalan helper for date localization
  - Support for multiple date formats (dd/mm/yy, dd/mm/yyyy)
  - Added Indonesian month names (full and abbreviated)
  - Support for formatted dates (25 Desember 2024, 23 Des 2024)
  - Added hyphenated date formats (25-12-2024, 25-12-24)
  - Integrated with autoloader configuration

### v1.0.5 (2024-12-25)
- Added Indonesian number formatting:
  - Added Angka helper for number localization
  - Support for thousand separators (23.000.000)
  - Support for currency format (15.000,-)
  - Support for decimal format (18.000.000,00)
  - Added number unformatting functionality
  - Integrated with autoloader configuration

Note: All dates are in YYYY-MM-DD format

```

# MEDKIT3

Medical Kit v3

## Changelog

### [1.0.1] - 2024-03-20
#### Added
- Master data obat (tbl_m_items)
  - Form input data obat
  - List data obat
  - Edit data obat
  - Delete data obat
- Migration for altering tbl_m_items table
  - Added status_obat column (1=obat;2=racikan;3=tindakan;4=lab;5=radiologi;6=bhp)
  - Modified status column to ENUM('0','1')

### [1.0.0] - Initial Release
- Base framework structure
- Authentication system
- Basic CRUD functionality
- Admin LTE 3 integration