# Mẫu Templates cho Programmatic SEO

## 📚 Danh sách Templates

### 1. Template Dịch vụ theo Thành phố (Location-Based Services)

**Use Case:** Tạo trang dịch vụ cho nhiều thành phố

**Title Template:**
```
Dịch vụ {{service}} tại {{city}} - Chuyên nghiệp, Uy tín
```

**Slug Pattern:**
```
{{city}}-{{service}}
```

**Content Template:**
```html
<h1>Dịch vụ {{service}} tại {{city}}</h1>

<div class="intro">
    <p><strong>{{description}}</strong></p>
    <p>Bạn đang tìm kiếm dịch vụ {{service}} chuyên nghiệp tại {{city}}? Chúng tôi cung cấp giải pháp tốt nhất với mức giá chỉ từ <strong>{{price}} VNĐ</strong>.</p>
</div>

<h2>Tại sao chọn dịch vụ {{service}} của chúng tôi tại {{city}}?</h2>

<div class="benefits">
    <ul>
        <li><strong>Đội ngũ chuyên nghiệp:</strong> Hơn 10 năm kinh nghiệm trong lĩnh vực {{service}}</li>
        <li><strong>Giá cả cạnh tranh:</strong> Chỉ từ {{price}} VNĐ, phù hợp mọi ngân sách</li>
        <li><strong>Hỗ trợ 24/7:</strong> Luôn sẵn sàng phục vụ khách hàng tại {{city}}</li>
        <li><strong>Bảo hành dài hạn:</strong> Cam kết chất lượng dịch vụ</li>
    </ul>
</div>

<h2>Quy trình làm việc</h2>
<ol>
    <li><strong>Liên hệ:</strong> Gọi hotline hoặc điền form để được tư vấn</li>
    <li><strong>Khảo sát:</strong> Chuyên gia đến tận nơi tại {{city}}</li>
    <li><strong>Báo giá:</strong> Báo giá chi tiết và minh bạch</li>
    <li><strong>Thực hiện:</strong> Triển khai dịch vụ {{service}} chuyên nghiệp</li>
</ol>

<h2>Dịch vụ {{service}} tại {{city}} - Cam kết của chúng tôi</h2>
<p>Với nhiều năm kinh nghiệm cung cấp dịch vụ {{service}} tại {{city}}, chúng tôi tự hào là đơn vị được nhiều khách hàng tin tưởng. Đội ngũ kỹ thuật viên của chúng tôi luôn được đào tạo chuyên sâu và cập nhật những công nghệ mới nhất.</p>

<div class="cta">
    <h3>Liên hệ ngay để nhận ưu đãi!</h3>
    <p><strong>Hotline:</strong> 0123 456 789</p>
    <p><strong>Email:</strong> contact@example.com</p>
</div>
```

**Meta Description:**
```
Dịch vụ {{service}} tại {{city}} chuyên nghiệp, giá từ {{price}}đ. Đội ngũ có kinh nghiệm, hỗ trợ 24/7. Liên hệ ngay để nhận ưu đãi!
```

**Variables:** `city, service, price, description`

---

### 2. Template Trang Sản phẩm (Product Pages)

**Use Case:** Tạo trang sản phẩm cho nhiều items

**Title Template:**
```
{{product_name}} - {{category}} Chính Hãng, Giá Tốt {{price}}đ
```

**Slug Pattern:**
```
{{category}}-{{product_slug}}
```

**Content Template:**
```html
<h1>{{product_name}}</h1>

<div class="product-intro">
    <p class="price"><strong>Giá:</strong> <span class="highlight">{{price}} VNĐ</span></p>
    <p class="sku"><strong>Mã sản phẩm:</strong> {{sku}}</p>
    <p class="category"><strong>Danh mục:</strong> {{category}}</p>
</div>

<h2>Mô tả sản phẩm {{product_name}}</h2>
<p>{{description}}</p>

<h2>Đặc điểm nổi bật</h2>
<ul>
    <li>{{feature_1}}</li>
    <li>{{feature_2}}</li>
    <li>{{feature_3}}</li>
</ul>

<h2>Thông số kỹ thuật</h2>
<table class="specs">
    <tr>
        <td><strong>Thương hiệu:</strong></td>
        <td>{{brand}}</td>
    </tr>
    <tr>
        <td><strong>Xuất xứ:</strong></td>
        <td>{{origin}}</td>
    </tr>
    <tr>
        <td><strong>Bảo hành:</strong></td>
        <td>{{warranty}}</td>
    </tr>
</table>

<h2>Tại sao chọn {{product_name}}?</h2>
<p>{{product_name}} là lựa chọn hoàn hảo trong phân khúc {{category}}. Với mức giá {{price}} VNĐ, bạn sẽ nhận được một sản phẩm chất lượng cao, đáng tin cậy và được bảo hành chính hãng.</p>

<div class="cta-box">
    <h3>Đặt hàng ngay hôm nay!</h3>
    <button>Mua ngay - {{price}} VNĐ</button>
    <p>Miễn phí vận chuyển cho đơn hàng trên 500.000đ</p>
</div>
```

**Meta Description:**
```
{{product_name}} giá {{price}}đ. {{description}}. Mua ngay tại cửa hàng chính hãng, bảo hành {{warranty}}.
```

**Variables:** `product_name, product_slug, category, price, sku, description, feature_1, feature_2, feature_3, brand, origin, warranty`

---

### 3. Template Blog Posts - Hướng dẫn (How-to Articles)

**Use Case:** Tạo bài viết hướng dẫn cho nhiều topics

**Title Template:**
```
Hướng dẫn {{topic}} chi tiết từ A-Z cho người mới bắt đầu
```

**Slug Pattern:**
```
huong-dan-{{topic_slug}}
```

**Content Template:**
```html
<h1>Hướng dẫn {{topic}} chi tiết từ A-Z</h1>

<p class="intro">Bạn đang muốn tìm hiểu về {{topic}}? Bài viết này sẽ hướng dẫn bạn <strong>{{topic}}</strong> một cách chi tiết và dễ hiểu nhất, phù hợp cho cả người mới bắt đầu.</p>

<h2>{{topic}} là gì?</h2>
<p>{{definition}}</p>

<h2>Tại sao cần biết về {{topic}}?</h2>
<ul>
    <li><strong>{{benefit_1}}</strong></li>
    <li><strong>{{benefit_2}}</strong></li>
    <li><strong>{{benefit_3}}</strong></li>
</ul>

<h2>Các bước thực hiện {{topic}}</h2>

<h3>Bước 1: {{step_1_title}}</h3>
<p>{{step_1_content}}</p>

<h3>Bước 2: {{step_2_title}}</h3>
<p>{{step_2_content}}</p>

<h3>Bước 3: {{step_3_title}}</h3>
<p>{{step_3_content}}</p>

<h2>Lưu ý khi thực hiện {{topic}}</h2>
<div class="warning-box">
    <p><strong>⚠️ Lưu ý:</strong> {{warning}}</p>
</div>

<h2>Kết luận</h2>
<p>Trên đây là hướng dẫn chi tiết về {{topic}}. Hy vọng bài viết đã giúp bạn hiểu rõ hơn về chủ đề này. Hãy thực hành thường xuyên để thành thạo!</p>

<div class="related-topics">
    <h3>Xem thêm:</h3>
    <p>Nếu bạn quan tâm đến {{topic}}, bạn có thể tìm hiểu thêm về {{related_topic}}.</p>
</div>
```

**Meta Description:**
```
Hướng dẫn {{topic}} chi tiết, dễ hiểu cho người mới. {{definition}}. Xem ngay để học cách thực hiện hiệu quả!
```

**Variables:** `topic, topic_slug, definition, benefit_1, benefit_2, benefit_3, step_1_title, step_1_content, step_2_title, step_2_content, step_3_title, step_3_content, warning, related_topic`

---

### 4. Template Landing Page - Địa điểm du lịch

**Use Case:** Tạo trang giới thiệu địa điểm du lịch

**Title Template:**
```
Du lịch {{destination}} {{year}} - Top {{attraction_count}} điểm đến hấp dẫn
```

**Slug Pattern:**
```
du-lich-{{destination_slug}}
```

**Content Template:**
```html
<h1>Du lịch {{destination}} - Khám phá vẻ đẹp tuyệt vời</h1>

<div class="destination-intro">
    <p>{{destination}} là một trong những điểm đến du lịch hấp dẫn nhất tại {{region}}. Với {{attraction_count}} địa điểm tham quan nổi tiếng, {{destination}} hứa hẹn mang đến cho bạn những trải nghiệm khó quên.</p>
</div>

<h2>Thời điểm lý tưởng du lịch {{destination}}</h2>
<p><strong>Mùa đẹp nhất:</strong> {{best_season}}</p>
<p><strong>Thời tiết:</strong> {{weather}}</p>

<h2>Top {{attraction_count}} điểm đến không thể bỏ qua tại {{destination}}</h2>

<h3>1. {{attraction_1}}</h3>
<p>{{attraction_1_desc}}</p>

<h3>2. {{attraction_2}}</h3>
<p>{{attraction_2_desc}}</p>

<h3>3. {{attraction_3}}</h3>
<p>{{attraction_3_desc}}</p>

<h2>Ẩm thực {{destination}}</h2>
<p>Đến {{destination}}, bạn nhất định phải thử:</p>
<ul>
    <li>{{food_1}}</li>
    <li>{{food_2}}</li>
    <li>{{food_3}}</li>
</ul>

<h2>Chi phí du lịch {{destination}}</h2>
<p><strong>Ước tính chi phí:</strong> {{estimated_cost}} VNĐ/người cho {{duration}} ngày</p>
<p>Bao gồm: Vé máy bay, khách sạn, ăn uống và tham quan.</p>

<h2>Tips du lịch {{destination}}</h2>
<div class="tips">
    <ul>
        <li>{{tip_1}}</li>
        <li>{{tip_2}}</li>
        <li>{{tip_3}}</li>
    </ul>
</div>

<div class="booking-cta">
    <h3>Đặt tour du lịch {{destination}} ngay!</h3>
    <p>Liên hệ: 0123 456 789 để được tư vấn và đặt tour</p>
</div>
```

**Meta Description:**
```
Du lịch {{destination}} {{year}} - Khám phá {{attraction_count}} điểm đến đẹp nhất. Mùa lý tưởng {{best_season}}. Chi phí từ {{estimated_cost}}đ. Đặt tour ngay!
```

**Variables:** `destination, destination_slug, year, attraction_count, region, best_season, weather, attraction_1, attraction_1_desc, attraction_2, attraction_2_desc, attraction_3, attraction_3_desc, food_1, food_2, food_3, estimated_cost, duration, tip_1, tip_2, tip_3`

---

### 5. Template Trang So sánh (Comparison Pages)

**Use Case:** Tạo trang so sánh sản phẩm/dịch vụ

**Title Template:**
```
So sánh {{product_a}} vs {{product_b}} - Nên chọn sản phẩm nào?
```

**Slug Pattern:**
```
so-sanh-{{product_a_slug}}-vs-{{product_b_slug}}
```

**Content Template:**
```html
<h1>So sánh {{product_a}} vs {{product_b}}</h1>

<p class="intro">Bạn đang phân vân giữa {{product_a}} và {{product_b}}? Bài viết này sẽ giúp bạn so sánh chi tiết hai sản phẩm để đưa ra lựa chọn phù hợp nhất.</p>

<h2>Tổng quan</h2>
<table class="comparison-table">
    <thead>
        <tr>
            <th>Tiêu chí</th>
            <th>{{product_a}}</th>
            <th>{{product_b}}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Giá</td>
            <td>{{price_a}} VNĐ</td>
            <td>{{price_b}} VNĐ</td>
        </tr>
        <tr>
            <td>Thương hiệu</td>
            <td>{{brand_a}}</td>
            <td>{{brand_b}}</td>
        </tr>
        <tr>
            <td>Đánh giá</td>
            <td>{{rating_a}}/5 ⭐</td>
            <td>{{rating_b}}/5 ⭐</td>
        </tr>
    </tbody>
</table>

<h2>Ưu điểm của {{product_a}}</h2>
<ul class="pros">
    <li>{{pro_a_1}}</li>
    <li>{{pro_a_2}}</li>
    <li>{{pro_a_3}}</li>
</ul>

<h2>Ưu điểm của {{product_b}}</h2>
<ul class="pros">
    <li>{{pro_b_1}}</li>
    <li>{{pro_b_2}}</li>
    <li>{{pro_b_3}}</li>
</ul>

<h2>Kết luận: Nên chọn sản phẩm nào?</h2>
<div class="conclusion">
    <p><strong>Chọn {{product_a}}</strong> nếu: {{when_choose_a}}</p>
    <p><strong>Chọn {{product_b}}</strong> nếu: {{when_choose_b}}</p>
</div>

<div class="winner">
    <h3>🏆 Lựa chọn của chúng tôi: {{winner}}</h3>
    <p>{{winner_reason}}</p>
</div>
```

**Meta Description:**
```
So sánh {{product_a}} vs {{product_b}} chi tiết. {{product_a}} giá {{price_a}}đ, {{product_b}} giá {{price_b}}đ. Xem ngay để chọn sản phẩm phù hợp!
```

**Variables:** `product_a, product_b, product_a_slug, product_b_slug, price_a, price_b, brand_a, brand_b, rating_a, rating_b, pro_a_1, pro_a_2, pro_a_3, pro_b_1, pro_b_2, pro_b_3, when_choose_a, when_choose_b, winner, winner_reason`

---

## 💡 Tips sử dụng Templates

1. **Chọn template phù hợp** với mục đích của bạn
2. **Customize content** để phù hợp với brand voice
3. **Test với 5-10 pages** trước khi generate hàng loạt
4. **Kiểm tra SEO** sau khi tạo pages
5. **Monitor performance** và điều chỉnh template nếu cần

## 📝 Cách tạo Template trong Plugin

1. Vào **Programmatic SEO** → **Templates**
2. Click **Thêm Template**
3. Copy nội dung từ mẫu trên
4. Paste vào các trường tương ứng
5. Điền danh sách **Variables** (phân cách bằng dấu phẩy)
6. Click **Lưu Template**
