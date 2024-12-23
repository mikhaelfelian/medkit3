# NUSANTARA HMVC 1.0 - Beta

## Created By

**Mikhael Felian Waskito**
Semarang, 23 December 2024

### About the Creator

As a developer with a passion for healthcare systems and Indonesian technological advancement, I created NUSANTARA HMVC to bridge the gap between modern web development and Indonesian healthcare needs. This framework represents not just code, but a vision of empowering Indonesian developers to create world-class healthcare solutions.

### Why NUSANTARA?

NUSANTARA, meaning "archipelago" in ancient Javanese, was chosen to represent:

1. **Unity in Diversity**: Like Indonesia's motto "Bhinneka Tunggal Ika", this framework unifies various components while maintaining their independence.

2. **Local Wisdom**: Incorporating Indonesian technological advancement while maintaining our cultural identity.

3. **Modular Architecture**: Just as Nusantara consists of thousands of islands working together as one nation, this HMVC framework consists of modular components working together as one system.

4. **Scalability**: Like the vast archipelago, this framework is designed to scale from small to enterprise applications.

### Vision

This framework embodies my commitment to:
- Advancing Indonesian healthcare technology
- Empowering local developers
- Creating globally competitive solutions
- Maintaining our cultural identity in technology

## About NUSANTARA

NUSANTARA, derived from the ancient Javanese term "Nusantara" meaning "archipelago", represents the vast Indonesian archipelago. This name was chosen to reflect:

1. **Unity in Diversity**: Like Indonesia's motto "Bhinneka Tunggal Ika", this framework unifies various components while maintaining their independence.

2. **Local Wisdom**: Incorporating Indonesian technological advancement while maintaining our cultural identity.

3. **Modular Architecture**: Just as Nusantara consists of thousands of islands working together as one nation, this HMVC framework consists of modular components working together as one system.

4. **Scalability**: Like the vast archipelago, this framework is designed to scale from small to enterprise applications.

A lightweight HMVC (Hierarchical Model-View-Controller) PHP framework with AdminLTE integration, designed with Indonesian healthcare systems in mind.

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx
- mod_rewrite enabled

## Quick Installation

1. Clone repository:
```bash
git clone https://github.com/mikhaelfelian/medkit3.git
cd medkit3
composer install
```

2. Database configuration:
```php
// config/config.php
$db_config = [
    'development' => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'db_klinik_esensia'
    ]
];
```

3. Run migrations:
```bash
php migrate.php
```

4. Set permissions (if on Linux/Unix):
```bash
chmod -R 755 public/uploads/
chmod -R 755 app/cache/
chmod -R 755 app/logs/
```

5. Access the application:
```
http://localhost/medkit3
```

Default login:
```
Username: admin
Password: admin123
```

## Development Setup

For local development:

1. Configure your Apache virtual host or use PHP's built-in server:
```bash
php -S localhost:8000 -t public/
```

2. Enable error reporting in development:
```php
// config/config.php
'debug_mode' => true
```

3. Install development dependencies:
```bash
composer install --dev
```

## Updating

To update the framework:
```bash
git pull origin main
composer update
php migrate.php
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

---
*"From Indonesia, For Indonesia"*
- Mikhael Felian Waskito
  Semarang, 23 December 2024

## Implementation Guide: SIMRS Klinik Utama Esensia

### About Implementation

First implementation of NUSANTARA HMVC Framework at:
**Klinik Utama Rawat Inap & Laboratorium Esensia Semarang**

### System Modules

1. **Patient Management**
   - Registration (Pendaftaran)
   - Medical Records (Rekam Medis)
   - Outpatient Care (Rawat Jalan)
   - Inpatient Care (Rawat Inap)
   - Laboratory Services (Layanan Laboratorium)

2. **Administrative Functions**
   - Appointment Scheduling
   - Queue Management
   - Billing System
   - Insurance Processing
   - Reporting System

3. **Clinical Features**
   - Doctor's Notes
   - Nurse's Notes
   - Prescription Management
   - Lab Results Integration
   - Treatment Plans

4. **Laboratory Management**
   - Test Orders
   - Sample Management
   - Result Recording
   - Quality Control
   - Lab Reports

### Database Structure

```sql
-- Example of key tables
CREATE TABLE pasien (
    id INT PRIMARY KEY AUTO_INCREMENT,
    no_rm VARCHAR(20) UNIQUE,
    nama VARCHAR(100),
    tgl_lahir DATE,
    alamat TEXT,
    no_telp VARCHAR(15),
    created_at TIMESTAMP
);

CREATE TABLE kunjungan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pasien_id INT,
    tgl_kunjungan DATETIME,
    jenis_layanan ENUM('Rawat Jalan', 'Rawat Inap', 'Laboratorium'),
    dokter_id INT,
    status VARCHAR(20),
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);
```

### Implementation Steps

1. **Initial Setup**
   ```bash
   git clone [repository-url]
   cd klinik-esensia
   composer install
   ```

2. **Database Configuration**
   ```php
   // config/config.php
   $db_config = [
       'development' => [
           'hostname' => 'localhost',
           'username' => 'root',
           'password' => '',
           'database' => 'db_klinik_esensia'
       ]
   ];
   ```

3. **Application Settings**
   ```php
   // Initial settings in pengaturan table
   $settings = [
       'judul_app' => 'SIMRS Klinik Utama Esensia',
       'logo' => 'assets/images/logo-esensia.png',
       'favicon' => 'assets/images/favicon-esensia.ico'
   ];
   ```

### Custom Modules

1. **Laboratory Integration**
   ```php
   // app/controllers/LaboratoriumController.php
   class LaboratoriumController extends BaseController {
       public function __construct() {
           parent::__construct();
           $this->loadModel('LaboratoriumModel');
       }

       public function index() {
           return $this->view('laboratorium/index', [
               'title' => 'Layanan Laboratorium'
           ]);
       }
   }
   ```

2. **Inpatient Management**
   ```php
   // app/controllers/RawatInapController.php
   class RawatInapController extends BaseController {
       public function __construct() {
           parent::__construct();
           $this->loadModel('RawatInapModel');
       }

       public function index() {
           return $this->view('rawat-inap/index', [
               'title' => 'Manajemen Rawat Inap'
           ]);
       }
   }
   ```

### Security Implementations

1. **User Roles**
   - Administrator
   - Doctor
   - Nurse
   - Laboratory Staff
   - Front Office
   - Billing Staff

2. **Access Control**
   ```php
   // Example of role-based access
   public function checkAccess($role) {
       if (!in_array($this->session->userRole, $role)) {
           return $this->redirect('auth/unauthorized');
       }
   }
   ```

### Reporting System

- Daily Patient Reports
- Monthly Revenue Reports
- Laboratory Test Reports
- Bed Occupancy Reports
- Medical Record Summaries

### Support & Maintenance

For technical support contact:
- Email: [your-email]
- Phone: [your-phone]

### Implementation Timeline

1. **Phase 1**: Basic Setup & Patient Management
2. **Phase 2**: Laboratory Integration
3. **Phase 3**: Billing & Insurance
4. **Phase 4**: Advanced Features & Reporting

---

Implemented by:
Mikhael Felian Waskito
Semarang, 23 December 2024

*"Advancing Healthcare Through Technology"*
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