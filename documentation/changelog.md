# Changelog

## v1.0.0 (2024-12-23)
- Initial release
- Core features implementation:
  - Patient data management
  - Dashboard analytics
  - User authentication
  - Database integration
  - Security implementations

[... previous versions ...]

## v1.0.6 (2024-03-20)
- Added master data obat management:
  - Added form input data obat with currency formatting
  - Added list data obat with thousand separators
  - Added edit and delete functionality
  - Added migration for tbl_m_items:
    - Added status_obat column with types (1=obat, 2=racikan, etc)
    - Modified status column to ENUM('0','1')
  - Integrated with existing security features
  - Added proper input validation and sanitization
  - Maintained consistent UI/UX with AdminLTE theme

## v1.0.7 (2024-03-20)
- Enhanced input security:
  - Added Input library for POST/GET handling
  - Added InputSanitizer library for data cleaning
  - Integrated automatic input sanitization
  - Protected against SQL injection attempts
  - Added HTML entity encoding
  - Implemented whitespace trimming
  - Added support for array sanitization
  - Maintained existing security patterns 