# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Created new ICD management module with CRUD functionality
- Added pagination configuration system in `config/pagination.php`
- Created reusable pagination library in `systems/libraries/Paginate.php`
- Added support for multiple pagination templates (Bootstrap 4, Bootstrap 3, Tailwind)

### Changed
- Moved pagination HTML templates to configuration file
- Renamed TblMPasienModel to PasienModel for better consistency
- Renamed TblPengaturanModel to PengaturanModel for better consistency
- Updated model references in controllers and views
- Refactored pagination to use template-based rendering

### Fixed
- Fixed pagination library path references in views
- Standardized model naming convention
- Improved code organization for pagination system

### Removed
- Removed hardcoded HTML from pagination library
- Removed old pagination files from app/library
- Removed redundant model name prefixes (Tbl) 
