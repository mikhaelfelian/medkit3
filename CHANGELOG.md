# Changelog

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