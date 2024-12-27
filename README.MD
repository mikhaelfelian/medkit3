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

## Key Features

### Architecture & Core
- HMVC Architecture
- PDO Database Layer
- Migration System
- Exception Handling
- Autoloader System
- Routing System

### Security
- Input Sanitization
- XSS Prevention
- CSRF Protection
- SQL Injection Protection
- Form Validation
- Security Headers
- Session Handling

### Frontend Integration
- AdminLTE 3 Integration
- Asset Management
- Standardized Form Styling
- Responsive Layouts
- AJAX Support
- Toastr Notifications

### Development Tools
- Error Logging
- Custom Error Pages
- Debug Mode
- Migration Tracking
- Code Documentation
- Inline Comments

### Data Management
- CRUD Operations
- Search Functionality
- Pagination System
- Status Management
- Timestamp Handling
- Code Generation

### Modules
- User Management
- Patient Records
- Medicine Inventory
- Warehouse Management
- Category Management
- Application Settings

## System Requirements

### Server Requirements
- PHP >= 7.4
  - PDO PHP Extension
  - MySQL PHP Extension
  - OpenSSL PHP Extension
  - Mbstring PHP Extension
  - JSON PHP Extension
  - XML PHP Extension
  - GD PHP Extension
  - Fileinfo Extension

### Database
- MySQL >= 5.7
  - InnoDB Storage Engine
  - UTF-8 Character Set
  - PDO Connection Support
  - Stored Procedures Support

### Web Server
- Apache 2.4+
  - mod_rewrite Enabled
  - .htaccess Enabled
  - AllowOverride All
- OR Nginx 1.16+
  - URL Rewrite Module
  - FastCGI Support

### Development Tools (Optional)
- Composer
- Git
- Web Browser (Chrome/Firefox latest)
- Text Editor/IDE (VSCode/PHPStorm)

### Recommended Server Specs
- Memory: 2GB RAM minimum
- Storage: 1GB free space
- Processor: Dual Core or better

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled
- PDO PHP Extension
- composer (optional)

### Step-by-Step Installation
1. Clone the repository
```bash
git clone https://github.com/mikhaelfelian/medkit3.git
cd medkit3
```

2. Database Setup
- Create a new MySQL database
- Import the database schema:
```bash
mysql -u your_username -p your_database_name < database/migrations/database.sql
```
- Or run migrations:
```bash
php migrate.php
```

3. Configuration
- Copy `config/config.example.php` to `config/config.php`
- Update database credentials:
```php
'DB_HOST' => 'localhost',
'DB_NAME' => 'your_database_name',
'DB_USER' => 'your_username',
'DB_PASS' => 'your_password'
```

4. Set Permissions
```bash
chmod 755 -R public/
chmod 755 -R app/
chmod 777 -R app/logs/
```

5. Web Server Configuration
- For Apache, ensure .htaccess is enabled:
```apache
<Directory /var/www/html>
    AllowOverride All
</Directory>
```
- For Nginx, configure URL rewriting:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

6. Access Application
- Point your web browser to: `http://localhost/medkit3`
- Default credentials:
  - Username: admin
  - Password: admin123

### Troubleshooting
- Ensure mod_rewrite is enabled
- Check file permissions
- Verify database connection
- Enable error reporting in development
- Check server logs for errors

## Directory Structure

```
ROOT_PATH/
├── app/
│   ├── controllers/
│   │   ├── GudangController.php
│   │   ├── KategoriController.php
│   │   ├── ObatController.php
│   │   ├── PasienController.php
│   │   └── PengaturanController.php
│   ├── models/
│   │   ├── GudangModel.php
│   │   ├── KategoriModel.php
│   │   ├── ObatModel.php
│   │   ├── PasienModel.php
│   │   └── PengaturanModel.php
│   ├── views/
│   │   ├── errors/
│   │   │   ├── 404.php
│   │   │   └── exception.php
│   │   ├── gudang/
│   │   │   ├── index.php
│   │   │   └── form.php
│   │   ├── kategori/
│   │   ├── layouts/
│   │   │   ├── main.php
│   │   │   ├── header.php
│   │   │   ├── footer.php
│   │   │   ├── navbar.php
│   │   │   └── sidebar.php
│   │   ├── obat/
│   │   │   ├── index.php
│   │   │   ├── form.php
��   │   │   └── show.php
│   │   └── pasien/
│   │       ├── index.php
│   │       ├── create.php
│   │       └── show.php
│   ├── helpers/
│   │   └── ViewHelper.php
│   ├── libraries/
│   │   └── Input.php
│   └── migrations/
│       └── 20240322_create_tbl_m_kategoris.php
├── systems/
│   ├── controllers/
│   │   └── BaseController.php
│   ├── models/
│   │   └── BaseModel.php
│   ├── routing/
│   │   └── BaseRouting.php
│   ├── exceptions/
│   │   ├── BaseException.php
│   │   └── Handler.php
│   └── helpers/
├── public/
│   └── assets/
│       ├── css/
│       ├── js/
│       └── vendor/
│           └── adminlte/
└── config/
    └── database.php
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
### v1.0.11 (2024-03-22)
#### Added
- Enhanced form standardization:
  - Added consistent form styling across modules
  - Added standardized input field styling
  - Added uniform rounded-0 class implementation
  - Added consistent validation attributes
  - Added standardized button styling

- View improvements:
  - Added standardized card layouts
  - Added consistent form group spacing
  - Added uniform input field styling
  - Added standardized button placement
  - Added consistent validation feedback

#### Changed
- Updated patient management module:
  - Refactored create.php to match obat form styling
  - Standardized form layout patterns
  - Updated input field classes
  - Improved form validation display
  - Enhanced user interface consistency

#### Enhanced
- Code organization:
  - Improved view file consistency
  - Standardized form templates
  - Enhanced visual hierarchy
  - Updated component styling
  - Unified design patterns

#### Fixed
- Fixed inconsistent form styling
- Fixed validation display issues
- Fixed button alignment
- Fixed input field spacing
- Fixed form group layouts

### v1.0.10 (2024-03-22)
#### Added
- Enhanced Gudang (Warehouse) management system:
  - Added status toggle switch functionality
  - Added AJAX-based status updates
  - Added real-time status display
  - Added toastr notifications for status changes
  - Added exception handling for warehouse operations

- Exception handling system:
  - Added BaseException class
  - Added Exception Handler
  - Added custom error pages
  - Added consistent error styling
  - Added error message display
  - Added exception logging

#### Changed
- Updated layout structure:
  - Moved script includes to main.php
  - Improved script management system
  - Added script pushing functionality
  - Enhanced BaseController with script handling
  - Standardized script loading order

#### Enhanced
- Form improvements:
  - Changed warehouse status to radio buttons
  - Simplified status options (Active/Inactive)
  - Enhanced form validation
  - Improved user interface
  - Added consistent styling

#### Fixed
- Fixed script loading issues
- Fixed status toggle persistence
- Fixed error page routing
- Fixed exception handling
- Fixed form validation feedback
- Fixed status update error handling

### v1.0.8 (2024-03-21)
#### Added
- Master data gudang management:
  - Added CRUD operations for gudang data
  - Added primary warehouse designation feature
  - Added status toggle functionality
  - Added warehouse code generation
  - Added search and pagination
  - Added form validation
  - Added proper error handling

#### Enhanced
- Input security and validation:
  - Added InputSanitizer library
  - Enhanced SQL injection protection
  - Added XSS prevention
  - Added input sanitization
  - Added validation rules
  - Added error handling

- Database migrations:
  - Added migration tracking system
  - Added migration results view
  - Added rollback functionality
  - Added migration logging
  - Added automatic table prefix handling

- Documentation:
  - Added detailed code documentation
  - Added inline code comments
  - Added migration documentation
  - Added security documentation
  - Updated helper documentation

#### Fixed
- Fixed database connection handling
- Fixed input sanitization issues
- Fixed CSRF token validation
- Fixed file upload security
- Fixed migration error handling
- Fixed form validation feedback
- Fixed security headers implementation

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

### v1.0.12 (2024-03-22)
#### Added
- Master data kategori management:
  - Added kategori table migration
  - Added KategoriModel with CRUD operations
  - Added timestamp handling
  - Added status management
  - Added search functionality

#### Enhanced
- Database structure:
  - Added tbl_m_kategoris table
  - Added proper collation settings
  - Added status enumeration
  - Added timestamp fields
  - Added proper indexing

#### Changed
- Model implementation:
  - Added standardized CRUD methods
  - Enhanced search capabilities
  - Improved timestamp handling
  - Added status update functionality
  - Implemented consistent patterns