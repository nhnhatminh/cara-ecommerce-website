# Cara Ecommerce v1.0

Nền tảng thương mại điện tử Fullstack dành cho thời trang và phụ kiện, tích hợp trang bán hàng cho khách hàng và hệ thống quản trị.

---

## Tính năng chính

### Khách hàng
* Xem danh sách sản phẩm, chi tiết sản phẩm, bài viết blog.
* Đăng ký, đăng nhập và quản lý thông tin tài khoản.
* Giỏ hàng linh hoạt, tiến hành đặt hàng và checkout.
* Theo dõi trạng thái đơn hàng.

### Quản trị viên
* Quản lý sản phẩm (thêm, sửa, xóa, danh mục).
* Quản lý đơn hàng và trạng thái xử lý.
* Quản lý thông tin khách hàng.

---

## Công nghệ sử dụng

* **Backend:** Native PHP
* **Database:** MySQL 8.0
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla JS)
* **DevOps:** Docker, Docker Compose

---

## Cấu trúc thư mục

* `admin/`: Giao diện và logic xử lý trang quản trị.
* `config/`: Cấu hình kết nối cơ sở dữ liệu.
* `core/`: Logic hệ thống (xác thực, giỏ hàng, hàm chung).
* `database/`: Script khởi tạo cơ sở dữ liệu.
* `includes/`: Thành phần giao diện dùng chung (header, footer).
* `public/`: Giao diện khách hàng và tài nguyên tĩnh (assets).

---

## Hướng dẫn Cài đặt & Khởi chạy

### 1. Yêu cầu
* Cài đặt và chạy **Docker Desktop** 
* Cài đặt **Git** trên máy.

### 2. Các bước thực hiện

#### Bước 1: Clone dự án và di chuyển vào thư mục
git clone <repository-url>
cd cara-ecommerce

#### Bước 2: Khởi chạy môi trường bằng Docker Compose
docker compose up -d

#### Truy cập
* Trang cửa http://localhost:8082/public/index.php
* Trang Quản trị http://localhost:8082/admin/index.php

#### Cổng kết nối
MySQL Host	127.0.0.1 (hoặc localhost)
MySQL Port	3308