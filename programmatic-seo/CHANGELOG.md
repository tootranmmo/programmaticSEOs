# Changelog

All notable changes to Programmatic SEO WordPress Plugin will be documented in this file.

---

## [1.0.1] - 2025-01-17

### 🐛 Bug Fixes

- **CRITICAL FIX**: Fixed template save failure caused by `sanitize_title()` removing `{{}}` from slug patterns
- Fixed slug pattern sanitization to preserve template variables
- Added proper error logging for database operations
- Improved data validation on save operations

### ✨ New Features

#### Template Preview
- Preview templates with sample data before saving
- Live preview of: Title, Slug, Content, Meta Description
- Sample data includes common variables (city, service, product, etc.)
- Preview modal with Bootstrap styling

#### Template Duplicate
- Clone existing templates with one click
- Duplicated templates marked as "inactive" and "(Copy)" in name
- Preserves all template settings and content

#### Template Export/Import
- Export templates to JSON format
- Import templates from JSON
- Includes metadata: plugin version, export date
- Portable templates for sharing between sites

#### Auto-extract Variables
- Automatically detect variables from templates
- Extracts from: Title, Content, Slug, Meta Description
- Updates variables field on blur
- Removes duplicates automatically

### 🎨 UI/UX Improvements

- **New Action Buttons**: Edit, Duplicate, Export, Delete
- **Import Button**: Added to main Templates page header
- **Enhanced Form**:
  - Better labels with examples
  - Inline help text for each field
  - Placeholder text with examples
  - Tips section with best practices
- **Preview Button**: View template rendering before save
- **Import Modal**: Paste JSON to import templates
- **Better Validation**: Client-side validation with error messages
- **Tooltips**: Hover tooltips for all action buttons

### 🔧 Technical Improvements

- **New AJAX Handlers**:
  - `pseo_duplicate_template` - Duplicate functionality
  - `pseo_export_template` - Export to JSON
  - `pseo_import_template` - Import from JSON
  - `pseo_preview_template` - Preview with sample data

- **Smart Slug Sanitization**:
  - Preserves `{{variables}}` syntax
  - Uses placeholder technique during sanitization
  - Restores variables after sanitization

- **Enhanced Validation**:
  - Required field validation (name, title, content)
  - JSON validation on import
  - Database operation result checking

- **Error Handling**:
  - Error logging with `error_log()`
  - AJAX error callbacks
  - User-friendly error messages

- **Code Quality**:
  - Added comments and documentation
  - Better function naming
  - Improved code organization

---

## [1.0.0] - 2025-01-17

### 🎉 Initial Release

#### Core Features

- **Template Management**: Create and manage content templates
- **Data Import**: Import CSV and JSON files
- **Bulk Page Generator**: Generate multiple pages from templates
- **SEO Optimization**: Auto meta tags, schema, Open Graph
- **Internal Linking**: Smart auto-linking between pages
- **Analytics Dashboard**: Track page performance
- **Bootstrap 4 UI**: Modern, responsive interface

#### Database

- Created 3 tables:
  - `wp_pseo_templates` - Template storage
  - `wp_pseo_data_sources` - Imported data
  - `wp_pseo_generated_pages` - Generated pages tracking

#### Documentation

- README.md - Full documentation
- INSTALLATION.md - Setup guide
- TEMPLATE-EXAMPLES.md - 5 template examples
- QUICKSTART.md - 5-minute quick start
- Sample CSV files included

#### Security

- Nonce verification
- Capability checking
- Data sanitization
- SQL injection prevention
- XSS protection

---

## Versioning

We use [Semantic Versioning](https://semver.org/):
- **MAJOR** version when incompatible API changes
- **MINOR** version when adding functionality (backwards-compatible)
- **PATCH** version for backwards-compatible bug fixes

---

## Support

- Report bugs: [GitHub Issues](https://github.com/tootranmmo/programmaticSEOs/issues)
- Documentation: [README.md](README.md)
- Quick Start: [QUICKSTART.md](QUICKSTART.md)

---

Made with ❤️ in Vietnam 🇻🇳
