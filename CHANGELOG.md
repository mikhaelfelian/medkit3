# Changelog

## [1.0.13] - 2024-03-22

### Added
- Enhanced form field handling:
  - Added readonly attribute implementation
  - Added dynamic field toggling
  - Added proper number formatting
  - Added currency formatting support
  - Added percentage input validation

### Changed
- Updated form interaction:
  - Changed disabled attributes to readonly
  - Improved field state management
  - Enhanced input validation
  - Standardized number formatting
  - Refined currency display

### Enhanced
- Input field behavior:
  - Improved data persistence
  - Enhanced field toggling logic
  - Standardized input restrictions
  - Refined validation feedback
  - Updated field state handling

### Fixed
- Fixed form field issues:
  - Fixed disabled field submissions
  - Fixed number format display
  - Fixed currency input handling
  - Fixed percentage validation
  - Fixed field state persistence

## [1.0.12] - 2024-03-22

### Added
- Master data kategori management:
  - Added kategori table migration
  - Added KategoriModel with CRUD operations
  - Added timestamp handling
  - Added status management
  - Added search functionality

### Enhanced
- Database structure:
  - Added tbl_m_kategoris table
  - Added proper collation settings
  - Added status enumeration
  - Added timestamp fields
  - Added proper indexing

### Changed
- Model implementation:
  - Added standardized CRUD methods
  - Enhanced search capabilities
  - Improved timestamp handling
  - Added status update functionality
  - Implemented consistent patterns

## [1.0.2] - 2024-03-XX

### Added
- Added Satuan management functionality
  - CRUD operations for Satuan
  - Active/Inactive status toggle
  - Validation for unique satuan names
  - Permanent delete functionality
  - Relationship with Obat items

### Changed
- Updated Obat form to include Satuan selection
- Modified database schema
  - Added id_satuan to tbl_m_items
  - Added status field to tbl_m_satuan
- Enhanced form validation rules

### Fixed
- Fixed Satuan selection in Obat forms
- Fixed status toggle functionality
- Fixed relationship constraints

### Technical
- Added Satuan model and controller
- Enhanced data validation
- Updated database queries for Satuan integration

## [1.0.1] - 2024-03-XX

### Added
- Added Merk management functionality
  - CRUD operations for Merk
  - Auto-generate Merk code (MRKYYMMxxxx format)
  - Active/Inactive status toggle
  - Validation for unique merk names
  - Permanent delete functionality

- Enhanced Obat management
  - Added Merk relationship to Obat
  - Added Kandungan (item_kand) field
  - Added currency formatting for prices
  - Added status toggle (Aktif/Tidak Aktif)
  - Auto-generate Obat code (OBYYMMxxxx format)

### Changed
- Updated Obat form to include Merk selection
- Modified database schema
  - Added id_merk to tbl_m_items
  - Added item_kand to tbl_m_items
  - Added status field to tbl_m_items
- Improved form validation
- Enhanced error handling
- Updated pagination styling

### Fixed
- Fixed currency formatting in forms
- Fixed dropdown selection in edit forms
- Fixed validation messages
- Fixed data relationships
- Fixed status handling

### Technical
- Added BaseModel::loadModel method
- Improved model validation
- Enhanced data integrity checks
- Updated database queries
- Improved error logging

## [1.0.0] - Initial Release
- Base functionality
- Basic CRUD operations
- Initial database structure 