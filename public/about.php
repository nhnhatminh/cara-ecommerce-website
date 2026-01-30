<?php 
session_start();
// 1. Cấu hình
$page = 'about'; // Để active menu "Giới thiệu"
$extraCss = 'assets/css/about.css'; // Load file CSS vừa tạo

// Mặc dù trang này tĩnh, nhưng vẫn include db.php để header hoạt động (check login)
require_once '../config/db.php'; 
include '../includes/header.php'; 
?>

<section id="page-header" class="about-header">
    <h2>#KnowUs</h2>
    <p>Tìm hiểu thêm về câu chuyện và sứ mệnh của Cara</p>
</section>

<section id="about-head" class="section-p1">
    <img src="assets/img/about/a6.jpg" alt="Về chúng tôi">
    
    <div>
        <h2>Chúng Tôi Là Ai?</h2>
        <p>
            Chào mừng bạn đến với không gian thời trang của chúng tôi! Xuất phát từ niềm đam mê cái đẹp, 
            chúng tôi không chỉ bán quần áo, mà còn mang đến giải pháp định hình phong cách cá nhân. 
            Mỗi bộ trang phục tại cửa hàng đều được tuyển chọn kỹ lưỡng, đảm bảo sự giao thoa hoàn hảo 
            giữa tính thời thượng và sự thoải mái tối đa.
        </p>
        <p>
            Chúng tôi tin rằng thời trang là ngôn ngữ không lời mạnh mẽ nhất để bạn khẳng định bản thân. 
            Với đội ngũ tận tâm và không ngừng đổi mới, chúng tôi cam kết đồng hành cùng bạn trên 
            hành trình tự tin tỏa sáng mỗi ngày.
        </p>
        
        <abbr title="">"Thời trang là cách bạn giới thiệu bản thân với thế giới mà không cần phải nói một lời nào."</abbr>
        
        <br><br>
        
        <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">
            Khám phá ngay bộ sưu tập mới nhất — Nâng tầm phong cách, khẳng định chất riêng!
        </marquee>
    </div>
</section>

<section id="about-app" class="section-p1">
    <h1>Tải Ứng Dụng Của <a href="#">Chúng Tôi</a></h1>
    <div class="video">
        <video autoplay muted loop src="assets/img/about/1.mp4"></video> 
    </div>
</section>

<section id="feature" class="section-p1">
    <div class="fe-box">
        <img src="assets/img/features/f1.png" alt="">
        <h6>Miễn phí Ship</h6>
    </div>
    <div class="fe-box">
        <img src="assets/img/features/f2.png" alt="">
        <h6>Đặt hàng Online</h6>
    </div>
    <div class="fe-box">
        <img src="assets/img/features/f3.png" alt="">
        <h6>Tiết kiệm</h6>
    </div>
    <div class="fe-box">
        <img src="assets/img/features/f4.png" alt="">
        <h6>Nhiều ưu đãi</h6>
    </div>
    <div class="fe-box">
        <img src="assets/img/features/f5.png" alt="">
        <h6>Mua sắm vui</h6>
    </div>
    <div class="fe-box">
        <img src="assets/img/features/f6.png" alt="">
        <h6>Hỗ trợ 24/7</h6>
    </div>
</section>

<section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
        <h4>Đăng ký để trải nghiệm những ưu đãi tuyệt vời</h4>
        <p>Nhận thông tin cập nhật mới nhất về cửa hàng và <span>ưu đãi đặc biệt qua Email.</span>
        </p>
    </div>
    <div class="form">
        <input type="text" placeholder="Your email address">
        <button class="normal">Đăng ký ngay!</button>
    </div>
</section>

<?php include '../includes/footer.php'; ?>