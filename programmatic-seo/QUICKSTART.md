# 🚀 Quick Start Guide - 5 phút bắt đầu

Hướng dẫn nhanh để tạo 100 trang SEO trong vài phút!

---

## ⚡ Bước 1: Cài đặt Plugin (1 phút)

### Cách 1: Upload qua WordPress Admin
1. Download plugin từ repository
2. Vào **Plugins** → **Add New** → **Upload Plugin**
3. Chọn file ZIP và **Install Now**
4. Click **Activate**

### Cách 2: FTP/cPanel
```bash
# Upload thư mục programmatic-seo vào:
/wp-content/plugins/programmatic-seo/
```
Sau đó activate trong WordPress Admin

---

## 📝 Bước 2: Tạo Template đầu tiên (2 phút)

1. Vào **Programmatic SEO** → **Templates**
2. Click **Thêm Template**

### Template mẫu: Dịch vụ theo thành phố

**Điền vào form:**

| Field | Value |
|-------|-------|
| **Tên Template** | Dịch vụ theo thành phố |
| **Post Type** | Page |
| **Title Template** | `Dịch vụ {{service}} tại {{city}} - Chuyên nghiệp, Uy tín` |
| **Slug Pattern** | `{{city}}-{{service}}` |
| **Variables** | `city, service, price, description` |

**Content Template:**
```html
<h1>Dịch vụ {{service}} tại {{city}}</h1>

<div class="intro">
    <p><strong>{{description}}</strong></p>
    <p>Bạn đang tìm kiếm dịch vụ {{service}} chuyên nghiệp tại {{city}}?
    Chúng tôi cung cấp giải pháp tốt nhất với mức giá chỉ từ
    <strong>{{price}} VNĐ</strong>.</p>
</div>

<h2>Tại sao chọn dịch vụ {{service}} của chúng tôi tại {{city}}?</h2>

<ul>
    <li><strong>Đội ngũ chuyên nghiệp:</strong> Hơn 10 năm kinh nghiệm</li>
    <li><strong>Giá cả cạnh tranh:</strong> Chỉ từ {{price}} VNĐ</li>
    <li><strong>Hỗ trợ 24/7:</strong> Luôn sẵn sàng phục vụ</li>
    <li><strong>Bảo hành dài hạn:</strong> Cam kết chất lượng</li>
</ul>

<h2>Liên hệ ngay để nhận ưu đãi!</h2>
<p><strong>Hotline:</strong> 0123 456 789</p>
```

**Meta Description:**
```
Dịch vụ {{service}} tại {{city}} chuyên nghiệp, giá từ {{price}}đ.
Đội ngũ có kinh nghiệm, hỗ trợ 24/7. Liên hệ ngay!
```

3. Click **Lưu Template** ✅

---

## 📊 Bước 3: Import Dữ liệu (1 phút)

### Option A: Sử dụng file mẫu có sẵn

1. Vào **Programmatic SEO** → **Data Import**
2. Chọn file `sample-data.csv` trong thư mục plugin
3. Nhập tên: "Dịch vụ Việt Nam"
4. Click **Upload & Import**

### Option B: Tạo file CSV của bạn

**Tạo file `my-data.csv`:**
```csv
city,service,price,description
Hà Nội,Web Development,5000000,Thiết kế website chuyên nghiệp
TP Hồ Chí Minh,SEO Marketing,3000000,Dịch vụ SEO tăng traffic
Đà Nẵng,UI/UX Design,4000000,Thiết kế giao diện đẹp mắt
Hải Phòng,Mobile App,6000000,Phát triển ứng dụng di động
Cần Thơ,E-commerce,7000000,Xây dựng website bán hàng
```

**Lưu ý:**
- Dòng đầu tiên phải là **header** (tên cột)
- Tên cột phải **khớp** với variables trong template
- Encoding phải là **UTF-8** để hỗ trợ tiếng Việt
- Không có dấu phẩy trong nội dung (hoặc dùng dấu ngoặc kép)

Upload file này lên trong **Data Import** ✅

---

## 🎯 Bước 4: Generate Pages (1 phút)

1. Vào **Programmatic SEO** → **Generate Pages**

2. **Cấu hình:**
   - **Template:** Chọn "Dịch vụ theo thành phố"
   - **Data Source:** Chọn data vừa import
   - **Giới hạn:** Để trống (tạo tất cả) hoặc nhập 10 để test
   - **Auto Publish:** Chọn "Lưu Draft" lần đầu để kiểm tra

3. Click **Bắt đầu Generate Pages** 🚀

4. **Đợi quá trình hoàn tất** (vài giây đến vài phút tùy số lượng)

5. Xem kết quả:
   - Vào **Pages** trong WordPress admin
   - Các pages đã được tạo với status "Draft"

---

## ✅ Bước 5: Kiểm tra và Publish

### Kiểm tra pages đã tạo

1. Vào **Pages** → Tìm pages vừa tạo
2. Click **Preview** một vài pages để kiểm tra
3. Xem:
   - ✅ Title có đúng không?
   - ✅ Content có hiển thị data không?
   - ✅ URL slug có đẹp không?
   - ✅ Meta description có đầy đủ không?

### Nếu OK → Publish

**Cách 1: Publish từng page**
- Vào page → Click **Publish**

**Cách 2: Bulk publish**
- Chọn nhiều pages
- **Bulk Actions** → **Edit**
- **Status** → **Published**
- Click **Update**

### Nếu cần sửa → Điều chỉnh template

1. Sửa template trong **Templates**
2. **Xóa** các pages draft cũ
3. **Generate lại** với template mới

---

## 📈 Bước 6: Monitor Analytics

1. Vào **Programmatic SEO** → **Analytics**
2. Xem:
   - 📊 Tổng số pages đã tạo
   - 👁️ Lượt xem
   - 🖱️ Clicks
   - 📈 Top performing pages

---

## 🎓 Tips cho người mới

### ✨ Best Practices

1. **Test với số lượng nhỏ trước**
   - Tạo 5-10 pages đầu tiên
   - Kiểm tra kỹ trước khi scale

2. **Optimize template**
   - Viết nội dung chất lượng
   - Thêm call-to-action
   - Sử dụng heading tags đúng cách

3. **Check SEO**
   - Title dài 50-60 ký tự
   - Meta description 150-160 ký tự
   - URL slug ngắn gọn, có từ khóa

4. **Monitor performance**
   - Xem Analytics thường xuyên
   - Điều chỉnh template nếu cần
   - A/B test các biến thể

### ⚠️ Tránh những lỗi này

❌ **Không kiểm tra trước khi generate hàng loạt**
- ✅ Luôn test với 5-10 pages trước

❌ **Variables không khớp với data columns**
- ✅ Kiểm tra tên cột CSV phải giống variables

❌ **Nội dung template quá ngắn/kém chất lượng**
- ✅ Viết content đầy đủ, có giá trị cho người đọc

❌ **Không backup trước khi generate**
- ✅ Backup database trước khi tạo hàng nghìn pages

❌ **Generate quá nhiều cùng lúc**
- ✅ Chia nhỏ thành các batch nếu có hàng nghìn dòng

---

## 🚀 Use Cases nhanh

### 1. Local Business (50 pages trong 5 phút)

**Data:** 10 cities × 5 services = 50 pages

```csv
city,service,price
Hà Nội,Sửa máy tính,500000
Hà Nội,Sửa laptop,600000
...
```

### 2. Product Catalog (100 pages trong 5 phút)

**Data:** 100 sản phẩm

```csv
product_name,price,description,brand
iPhone 14,25000000,Điện thoại cao cấp,Apple
Samsung S23,20000000,Android flagship,Samsung
...
```

### 3. Blog Content (200 pages trong 10 phút)

**Data:** 200 topics

```csv
topic,category,difficulty
Học tiếng Anh,Giáo dục,Dễ
Đầu tư chứng khoán,Tài chính,Trung bình
...
```

---

## 🎯 Mục tiêu đạt được

Sau 5 phút với guide này, bạn đã:

- ✅ Cài đặt plugin thành công
- ✅ Tạo template đầu tiên
- ✅ Import dữ liệu
- ✅ Generate pages tự động
- ✅ Hiểu cách sử dụng cơ bản

---

## 📚 Tiếp theo

### Tìm hiểu thêm:

1. **[TEMPLATE-EXAMPLES.md](TEMPLATE-EXAMPLES.md)**
   - 5 mẫu templates chi tiết
   - Use cases khác nhau
   - Best practices

2. **[README.md](README.md)**
   - Documentation đầy đủ
   - Tất cả tính năng
   - Roadmap và contribution

3. **[INSTALLATION.md](INSTALLATION.md)**
   - Hướng dẫn cài đặt chi tiết
   - Troubleshooting
   - Configuration

### Sample Data Files:

- `sample-data.csv` - Dịch vụ theo thành phố
- `sample-data-products.csv` - Catalog sản phẩm
- `sample-data-travel.csv` - Địa điểm du lịch
- `sample-data-howto.csv` - Bài viết hướng dẫn

---

## 💡 Câu hỏi thường gặp

**Q: Tôi có thể tạo bao nhiêu pages?**
A: Không giới hạn! Từ vài trang đến hàng nghìn trang.

**Q: Plugin có tương thích với theme của tôi không?**
A: Có! Plugin hoạt động với mọi theme WordPress chuẩn.

**Q: Tôi có thể sửa pages sau khi tạo không?**
A: Có! Pages được tạo giống pages WordPress thông thường, bạn có thể edit thoải mái.

**Q: Dữ liệu có bị xóa khi deactivate plugin không?**
A: Không. Dữ liệu chỉ bị xóa khi bạn **uninstall** plugin.

**Q: Tôi có thể xuất dữ liệu analytics không?**
A: Hiện tại chưa có tính năng này. Sẽ có trong version 1.1.0.

---

## 🆘 Cần trợ giúp?

- 📖 **Documentation:** [README.md](README.md)
- 🐛 **Report Bug:** [GitHub Issues](https://github.com/tootranmmo/programmaticSEOs/issues)
- 💬 **Community:** [Discussions](https://github.com/tootranmmo/programmaticSEOs/discussions)

---

<div align="center">

**🎉 Chúc bạn thành công với Programmatic SEO!**

Made with ❤️ in Vietnam 🇻🇳

[⭐ Star on GitHub](https://github.com/tootranmmo/programmaticSEOs)

</div>
