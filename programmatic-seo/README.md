# Programmatic SEO WordPress Plugin

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue)
![PHP](https://img.shields.io/badge/PHP-7.2%2B-purple)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green)

**Tạo hàng loạt trang SEO tự động từ template và dữ liệu.** Plugin WordPress chuyên nghiệp với giao diện Bootstrap 4 tươi sáng, giúp bạn scale content marketing một cách hiệu quả.

---

## 🚀 Tính năng chính

### 🎨 Template Management
- Tạo, sửa, xóa templates với biến động `{{variable}}`
- Hỗ trợ title, content, slug pattern, meta description
- Tự động extract variables từ template
- Preview template trước khi generate

### 📊 Data Import
- Import dữ liệu từ **CSV** và **JSON**
- Upload file với validation
- Lưu trữ metadata và columns information
- Sample data files đi kèm

### ⚡ Bulk Page Generator
- Tạo hàng loạt pages từ template + data
- Tùy chọn **auto-publish** hoặc **draft**
- Giới hạn số lượng pages tạo
- Error handling và reporting chi tiết

### 🔍 SEO Optimization
- Auto-generate meta description
- **Open Graph** tags (Facebook)
- **Twitter Card** tags
- **Schema.org** JSON-LD markup
- Featured image support

### 🔗 Internal Linking
- Tự động tạo liên kết giữa các trang cùng template
- Smart random selection
- Styled internal links section

### 📈 Analytics Dashboard
- Thống kê tổng quan (pages, views, clicks)
- Charts với **Chart.js** (pie & bar charts)
- Top 10 performing pages
- Performance by template
- CTR calculation

### 🎨 Bootstrap 4 UI
- Giao diện hiện đại, tươi sáng
- Responsive design
- Card-based layout với gradient colors
- Font Awesome icons
- Smooth animations

---

## 📦 Cài đặt

### Yêu cầu hệ thống
- WordPress 5.0+
- PHP 7.2+
- MySQL 5.6+

### Cài đặt từ source

1. **Clone repository:**
```bash
git clone https://github.com/tootranmmo/programmaticSEOs.git
cd programmaticSEOs
```

2. **Copy vào WordPress:**
```bash
cp -r programmatic-seo /path/to/wordpress/wp-content/plugins/
```

3. **Activate plugin:**
- Vào **WordPress Admin** → **Plugins**
- Tìm "Programmatic SEO"
- Click **Activate**

### Cài đặt từ ZIP

1. Nén thư mục `programmatic-seo` thành ZIP
2. Vào **Plugins** → **Add New** → **Upload Plugin**
3. Chọn file ZIP và click **Install Now**
4. Click **Activate Plugin**

📖 **Chi tiết:** Xem [INSTALLATION.md](INSTALLATION.md)

---

## 🎯 Quick Start

### 1️⃣ Tạo Template đầu tiên

Vào **Programmatic SEO** → **Templates** → **Thêm Template**

**Ví dụ Template:**
```
Title: Dịch vụ {{service}} tại {{city}} - Giá {{price}} VNĐ
Slug: {{city}}-{{service}}
Content:
  <h1>Dịch vụ {{service}} tại {{city}}</h1>
  <p>Chúng tôi cung cấp dịch vụ {{service}} chuyên nghiệp...</p>
Meta: Dịch vụ {{service}} tại {{city}} giá {{price}}đ...
Variables: city, service, price
```

### 2️⃣ Import dữ liệu

Vào **Data Import** và upload file CSV:

```csv
city,service,price
Hà Nội,Web Development,5000000
TP HCM,SEO Marketing,3000000
Đà Nẵng,UI/UX Design,4000000
```

### 3️⃣ Generate Pages

Vào **Generate Pages** → Chọn Template + Data → **Generate!**

🎉 **Xong!** Plugin sẽ tạo tự động các trang với nội dung tương ứng.

---

## 📁 Cấu trúc Plugin

```
programmatic-seo/
├── programmatic-seo.php          # Main plugin file
├── readme.txt                     # WordPress plugin readme
├── uninstall.php                  # Uninstall cleanup
├── README.md                      # Documentation (this file)
├── INSTALLATION.md                # Installation guide
├── TEMPLATE-EXAMPLES.md           # Template examples & guides
│
├── Sample Data Files:
├── sample-data.csv                # Services by city
├── sample-data-products.csv       # Product catalog
├── sample-data-travel.csv         # Travel destinations
├── sample-data-howto.csv          # How-to articles
│
├── includes/                      # Core functionality
│   ├── class-pseo-activator.php
│   ├── class-pseo-deactivator.php
│   ├── class-pseo-core.php
│   ├── class-pseo-template.php
│   ├── class-pseo-data-importer.php
│   ├── class-pseo-page-generator.php
│   └── class-pseo-seo-optimizer.php
│
└── admin/                         # Admin interface
    ├── class-pseo-admin.php
    ├── css/
    │   └── admin-style.css
    ├── js/
    │   └── admin-script.js
    └── views/
        ├── dashboard.php
        ├── templates.php
        ├── data-import.php
        ├── page-generator.php
        └── analytics.php
```

---

## 📚 Tài liệu và Mẫu

### 📖 Guides
- **[INSTALLATION.md](INSTALLATION.md)** - Hướng dẫn cài đặt chi tiết
- **[TEMPLATE-EXAMPLES.md](TEMPLATE-EXAMPLES.md)** - 5 mẫu templates cho các use case khác nhau

### 📊 Sample Data Files

Plugin đi kèm 4 file CSV mẫu:

1. **sample-data.csv** - Dịch vụ theo thành phố (5 rows)
2. **sample-data-products.csv** - Catalog sản phẩm (10 rows)
3. **sample-data-travel.csv** - Địa điểm du lịch (10 rows)
4. **sample-data-howto.csv** - Bài viết hướng dẫn (10 rows)

### 🎨 Template Examples

5 mẫu templates sẵn có:

1. **Location-Based Services** - Dịch vụ theo địa điểm
2. **Product Pages** - Trang sản phẩm
3. **How-to Articles** - Bài viết hướng dẫn
4. **Travel Destinations** - Địa điểm du lịch
5. **Comparison Pages** - Trang so sánh

---

## 🎨 Screenshots

### Dashboard
![Dashboard](https://via.placeholder.com/800x400/667eea/ffffff?text=Dashboard+Overview)
*Tổng quan thống kê với cards và charts*

### Template Management
![Templates](https://via.placeholder.com/800x400/27ae60/ffffff?text=Template+Management)
*Quản lý templates với modal tạo/sửa*

### Data Import
![Import](https://via.placeholder.com/800x400/3498db/ffffff?text=Data+Import)
*Import CSV/JSON với validation*

### Page Generator
![Generator](https://via.placeholder.com/800x400/f39c12/ffffff?text=Page+Generator)
*Generate pages với preview*

### Analytics
![Analytics](https://via.placeholder.com/800x400/e74c3c/ffffff?text=Analytics+Dashboard)
*Analytics với charts và top pages*

---

## 🔒 Bảo mật

Plugin được xây dựng với các tiêu chuẩn bảo mật cao:

- ✅ **Nonce verification** cho tất cả AJAX requests
- ✅ **Capability checking** (`manage_options`)
- ✅ **Data sanitization** (sanitize_text_field, wp_kses_post)
- ✅ **SQL injection prevention** (wpdb prepare)
- ✅ **XSS protection** (esc_html, esc_attr, esc_url)
- ✅ **File type validation**
- ✅ **ABSPATH checking**

---

## 💾 Database Schema

Plugin tạo 3 bảng khi activate:

### `wp_pseo_templates`
Lưu trữ templates với các fields:
- id, name, description
- title_template, content_template
- meta_description_template, slug_pattern
- post_type, status, variables
- created_at, updated_at

### `wp_pseo_data_sources`
Lưu trữ data sources đã import:
- id, name, file_name, file_path
- file_type, total_rows, columns
- status, created_at

### `wp_pseo_generated_pages`
Track các pages đã tạo và analytics:
- id, post_id, template_id, data_source_id
- data_row_index, views, clicks
- created_at

---

## 🛠️ Development

### Setup môi trường dev

```bash
# Clone repo
git clone https://github.com/tootranmmo/programmaticSEOs.git

# Install dependencies (if any)
composer install
npm install

# Symlink to WordPress
ln -s $(pwd)/programmatic-seo /path/to/wordpress/wp-content/plugins/
```

### Code Standards

- **PHP:** WordPress Coding Standards
- **CSS:** BEM methodology
- **JS:** ES6+ với jQuery
- **Security:** WordPress Security Best Practices

### Testing

```bash
# PHP syntax check
find . -name "*.php" -exec php -l {} \;

# WordPress coding standards (requires PHPCS)
phpcs --standard=WordPress programmatic-seo/
```

---

## 📝 Use Cases

### 1. Local Business SEO
Tạo pages cho dịch vụ tại nhiều thành phố/quận/huyện

**Template:** "Dịch vụ {{service}} tại {{location}}"
**Data:** Danh sách locations + services

### 2. E-commerce Product Pages
Tạo pages sản phẩm từ catalog

**Template:** "{{product_name}} - {{category}}"
**Data:** Product catalog từ CSV/database

### 3. Travel & Tourism
Tạo pages giới thiệu địa điểm du lịch

**Template:** "Du lịch {{destination}} - Top {{count}} điểm đến"
**Data:** Destinations với attractions và tips

### 4. Educational Content
Tạo bài viết hướng dẫn cho nhiều topics

**Template:** "Hướng dẫn {{topic}} từ A-Z"
**Data:** Topics với steps và examples

### 5. Real Estate Listings
Tạo pages cho BĐS tại nhiều khu vực

**Template:** "{{property_type}} tại {{area}} - {{price}}"
**Data:** Property listings

---

## 🎯 Roadmap

### Version 1.1.0 (Planning)
- [ ] Scheduled generation (cron jobs)
- [ ] Template variables suggestions
- [ ] Bulk edit generated pages
- [ ] Export analytics to CSV

### Version 1.2.0 (Future)
- [ ] Integration with Google Search Console
- [ ] AI-powered content suggestions
- [ ] Multi-language support
- [ ] REST API endpoints

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the GPL-2.0+ License.

```
Programmatic SEO WordPress Plugin
Copyright (C) 2025

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
```

---

## 📞 Support & Contact

- **GitHub Issues:** [Report bugs](https://github.com/tootranmmo/programmaticSEOs/issues)
- **Documentation:** [Wiki](https://github.com/tootranmmo/programmaticSEOs/wiki)
- **Email:** support@example.com

---

## ⭐ Credits

Developed with ❤️ by [tootranmmo](https://github.com/tootranmmo)

### Built with:
- [WordPress](https://wordpress.org/)
- [Bootstrap 4](https://getbootstrap.com/)
- [Font Awesome](https://fontawesome.com/)
- [Chart.js](https://www.chartjs.org/)

---

## 🙏 Acknowledgments

- WordPress community for amazing documentation
- Bootstrap team for the beautiful UI framework
- All contributors and users

---

<div align="center">

**⭐ Star this repo if you find it helpful!**

[Report Bug](https://github.com/tootranmmo/programmaticSEOs/issues) · [Request Feature](https://github.com/tootranmmo/programmaticSEOs/issues)

Made with ❤️ in Vietnam 🇻🇳

</div>
