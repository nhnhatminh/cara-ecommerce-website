# Sử dụng PHP 8.2 kết hợp Apache làm nền tảng
FROM php:8.2-apache

# Cài đặt các thư viện cần thiết để PHP kết nối được MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Kích hoạt mod_rewrite của Apache (quan trọng cho các file .htaccess)
RUN a2enmod rewrite

# Sao chép toàn bộ mã nguồn vào thư mục mặc định của Apache trong Container
COPY . /var/www/html/

# Phân quyền để Apache có thể đọc/ghi file (tránh lỗi khi upload ảnh sản phẩm)
RUN chown -R www-data:www-data /var/www/html

# Port mặc định mà Container sẽ mở
EXPOSE 80