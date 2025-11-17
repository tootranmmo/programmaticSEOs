# Programmatic SEO Plugin - Hướng dẫn cài đặt

## 📦 Cài đặt

### Cách 1: Cài đặt thủ công
1. Download toàn bộ thư mục `programmatic-seo`
2. Upload vào `/wp-content/plugins/` của WordPress
3. Vào **Plugins** → Tìm **Programmatic SEO** → Click **Activate**

### Cách 2: Cài đặt từ ZIP
1. Nén thư mục `programmatic-seo` thành file `programmatic-seo.zip`
2. Vào **Plugins** → **Add New** → **Upload Plugin**
3. Chọn file ZIP và click **Install Now**
4. Click **Activate Plugin**

## 🚀 Bắt đầu sử dụng

### Bước 1: Tạo Template
1. Vào **Programmatic SEO** → **Templates**
2. Click **Thêm Template**
3. Điền thông tin:
   - **Tên Template**: "Dịch vụ theo thành phố"
   - **Title Template**: `Dịch vụ {{service}} tại {{city}} - Giá {{price}} VNĐ`
   - **Slug Pattern**: `{{city}}-{{service}}`
   - **Content Template**:
     ```
     <h1>Dịch vụ {{service}} tại {{city}}</h1>

     <p>{{description}}</p>

     <p>Chúng tôi cung cấp dịch vụ {{service}} chuyên nghiệp tại {{city}}
     với giá chỉ từ {{price}} VNĐ.</p>

     <h2>Tại sao chọn chúng tôi?</h2>
     <ul>
       <li>Đội ngũ chuyên nghiệp</li>
       <li>Giá cả cạnh tranh</li>
       <li>Hỗ trợ 24/7</li>
     </ul>
     ```
   - **Meta Description**: `Dịch vụ {{service}} tại {{city}} giá {{price}}. Liên hệ ngay để nhận tư vấn miễn phí!`
4. Click **Lưu Template**

### Bước 2: Import Dữ liệu
1. Vào **Programmatic SEO** → **Data Import**
2. Sử dụng file mẫu `sample-data.csv` hoặc tạo file CSV của bạn
3. Nhập tên data source và upload file
4. Click **Upload & Import**

### Bước 3: Generate Pages
1. Vào **Programmatic SEO** → **Generate Pages**
2. Chọn Template đã tạo
3. Chọn Data Source đã import
4. Chọn **Auto Publish** hoặc **Lưu Draft**
5. Click **Bắt đầu Generate Pages**
6. Đợi quá trình hoàn tất

### Bước 4: Xem Analytics
1. Vào **Programmatic SEO** → **Analytics**
2. Xem thống kê về số trang đã tạo, lượt xem, clicks
3. Theo dõi top pages có hiệu suất cao nhất

## 📊 File CSV mẫu

```csv
city,service,price,description
Hà Nội,Web Development,5000000,Thiết kế website chuyên nghiệp
TP Hồ Chí Minh,SEO Marketing,3000000,Dịch vụ SEO tăng traffic
Đà Nẵng,UI/UX Design,4000000,Thiết kế giao diện đẹp mắt
```

## ⚙️ Yêu cầu hệ thống

- WordPress 5.0 trở lên
- PHP 7.2 trở lên
- MySQL 5.6 trở lên

## 🔧 Cấu hình PHP khuyến nghị

```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

## 🛠️ Xử lý sự cố

### Plugin không activate được
- Kiểm tra PHP version >= 7.2
- Kiểm tra quyền thư mục wp-content/plugins/
- Xem log lỗi trong wp-content/debug.log

### Upload file CSV lỗi
- Kiểm tra encoding file phải là UTF-8
- Kiểm tra upload_max_filesize trong php.ini
- Đảm bảo file CSV có header row

### Generate pages không hoạt động
- Kiểm tra biến trong template khớp với columns trong data
- Tăng max_execution_time nếu tạo nhiều pages
- Kiểm tra memory_limit đủ lớn

## 📝 Ghi chú

- **Backup dữ liệu** trước khi cài đặt
- **Test với số lượng nhỏ** trước (5-10 pages)
- **Kiểm tra preview** template trước khi generate hàng loạt
- **Monitor performance** sau khi tạo nhiều pages

## 🔐 Bảo mật

Plugin đã được tối ưu bảo mật:
- Nonce verification cho tất cả AJAX requests
- Capability checking (manage_options)
- Data sanitization và validation
- SQL injection prevention
- XSS protection

## 📞 Hỗ trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra [documentation](https://github.com/tootranmmo/programmaticSEOs)
2. Tạo issue trên GitHub
3. Liên hệ support team

## 📄 License

GPL-2.0+
