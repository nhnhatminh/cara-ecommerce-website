<?php
session_start();
require_once '../config/db.php';

$message_status = "";

// XỬ LÝ KHI NGƯỜI DÙNG GỬI FORM
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $subject, $message])) {
                $message_status = "<script>alert('Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn và sẽ phản hồi sớm nhất.');</script>";
            }
        } catch (PDOException $e) {
            $message_status = "<script>alert('Lỗi: Không thể gửi tin nhắn lúc này.');</script>";
        }
    } else {
        $message_status = "<script>alert('Vui lòng điền đầy đủ thông tin!');</script>";
    }
}

// Tự động điền thông tin nếu đã đăng nhập
$pre_name = $_SESSION['user_name'] ?? '';
$pre_email = $_SESSION['user_email'] ?? '';

// Cấu hình Header
$page = 'contact';
$extraCss = 'assets/css/contact.css'; // File CSS riêng cho trang này
include '../includes/header.php';
?>

<?php echo $message_status; ?>

<section id="page-header" class="about-header">
    <h2>#LetsTalk</h2>
    <p>Hãy để lại lời nhắn, chúng tôi rất muốn lắng nghe ý kiến của bạn!</p>
</section>

<section id="contact-details" class="section-p1">
    <div class="details">
        <span>LIÊN LẠC</span>
        <h2>Ghé thăm văn phòng của chúng tôi</h2>
        <h3>Trụ sở chính</h3>
        <div>
            <li>
                <i class="fal fa-map"></i>
                <p>Số 196 Pasteur, phường Xuân Hòa, Thành phố Hồ Chí Minh</p>
            </li>
            <li>
                <i class="fal fa-envelope"></i>
                <p>contact@cara.com</p>
            </li>
            <li>
                <i class="fal fa-phone-alt"></i>
                <p>+84 123 456 789</p>
            </li>
            <li>
                <i class="fal fa-clock"></i>
                <p>Thứ 2 - Thứ 7: 9:00 - 18:00</p>
            </li>
        </div>
    </div>

    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241684343163!2d106.68783431533423!3d10.778790262096492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f2fa20f8781%3A0x69680c4366df6836!2zMTk2IFBhc3RldXIsIFBoxrDhu51uZyA2LCBRdeG6rW4gMywgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1642131234567!5m2!1sen!2s" 
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<section id="form-details">
    <form action="" method="POST">
        <span>ĐỂ LẠI LỜI NHẮN</span>
        <h2>Chúng tôi luôn lắng nghe bạn</h2>
        <input type="text" name="name" placeholder="Họ và Tên" value="<?php echo htmlspecialchars($pre_name); ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($pre_email); ?>" required>
        <input type="text" name="subject" placeholder="Tiêu đề">
        <textarea name="message" cols="30" rows="10" placeholder="Nội dung tin nhắn..." required></textarea>
        <button class="normal">Gửi Tin Nhắn</button>
    </form>

    <div class="people">
        <div>
            <img src="assets/img/people/default-pfp.png" alt="">
            <p><span>Trương Tam Phong</span> Senior Marketing Manager <br> Phone: +84 123 123 123 <br> Email: phongtt56@cara.com</p>
        </div>
        <div>
            <img src="assets/img/people/default-pfp.png" alt="">
            <p><span>Nguyễn H Nhật Minh</span> Senior Developer <br> Phone: +84 123 123 124 <br> Email: minhnhn@cara.com</p>
        </div>
        <div>
            <img src="assets/img/people/default-pfp.png" alt="">
            <p><span>Kỷ Hiểu Phù</span> Customer Support <br> Phone: +84 123 123 125 <br> Email: khp2305@cara.com</p>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>