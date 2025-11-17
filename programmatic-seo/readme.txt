=== Programmatic SEO ===
Contributors: tootranmmo
Tags: seo, programmatic, bulk pages, automation, template
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tạo hàng loạt trang SEO tự động từ template và dữ liệu. Tối ưu SEO với meta tags, schema markup và internal linking.

== Description ==

Programmatic SEO là plugin WordPress mạnh mẽ giúp bạn tạo hàng loạt trang SEO tự động từ template và dữ liệu. Plugin hỗ trợ import dữ liệu từ CSV/JSON và tạo nội dung động với các biến.

= Tính năng chính =

* **Template Management** - Tạo và quản lý template nội dung với biến động
* **Data Import** - Import dữ liệu từ file CSV và JSON
* **Bulk Page Generator** - Tạo hàng loạt trang tự động từ template và data
* **SEO Optimization** - Tự động tạo meta tags, Open Graph, Schema.org markup
* **Internal Linking** - Tự động tạo liên kết nội bộ giữa các trang liên quan
* **Analytics Dashboard** - Theo dõi hiệu suất và lượt xem của các trang đã tạo
* **Bootstrap 4 UI** - Giao diện admin hiện đại và dễ sử dụng

= Cách sử dụng =

1. **Tạo Template**: Tạo template nội dung với các biến {{variable_name}}
2. **Import Data**: Upload file CSV hoặc JSON chứa dữ liệu
3. **Generate Pages**: Chọn template và data source để tạo pages tự động
4. **Monitor**: Theo dõi hiệu suất qua Analytics dashboard

= Ví dụ Template =

Title: Dịch vụ {{service}} tại {{city}}
Content: Chúng tôi cung cấp dịch vụ {{service}} chuyên nghiệp tại {{city}}...

= Ví dụ Data CSV =

```
city,service,price
Hà Nội,Web Development,5000000
TP HCM,SEO Marketing,3000000
```

Plugin sẽ tự động tạo các trang với nội dung tương ứng.

== Installation ==

1. Upload thư mục `programmatic-seo` vào `/wp-content/plugins/`
2. Activate plugin trong menu 'Plugins' của WordPress
3. Truy cập 'Programmatic SEO' trong admin menu để bắt đầu

== Frequently Asked Questions ==

= Plugin có tương thích với theme của tôi không? =

Có, plugin hoạt động với tất cả các theme WordPress chuẩn.

= Tôi có thể tạo bao nhiêu pages? =

Không giới hạn. Bạn có thể tạo từ vài trang đến hàng nghìn trang.

= Plugin có hỗ trợ tiếng Việt không? =

Có, plugin hoàn toàn hỗ trợ tiếng Việt với encoding UTF-8.

= Dữ liệu có được xóa khi deactivate plugin không? =

Không. Dữ liệu chỉ được xóa khi bạn uninstall plugin.

== Screenshots ==

1. Dashboard - Tổng quan thống kê
2. Templates Management - Quản lý template
3. Data Import - Import dữ liệu từ CSV/JSON
4. Page Generator - Tạo pages tự động
5. Analytics - Theo dõi hiệu suất

== Changelog ==

= 1.0.0 =
* Phiên bản đầu tiên
* Template management với biến động
* Import CSV và JSON
* Bulk page generation
* SEO optimization tự động
* Internal linking thông minh
* Analytics dashboard
* Bootstrap 4 UI

== Upgrade Notice ==

= 1.0.0 =
Phiên bản đầu tiên của plugin.

== Additional Info ==

Để báo cáo bug hoặc đóng góp, vui lòng truy cập:
https://github.com/tootranmmo/programmaticSEOs
