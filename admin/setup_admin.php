<?php
require_once '../config/db.php';

// Cấu hình tài khoản Admin muốn tạo
$full_name = "Minh Admin";
$email = "admin@gmail.com";
$password_plain = "Admin@1234"; // Mật khẩu bạn muốn đặt

// 1. Kiểm tra xem email này đã tồn tại chưa
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    echo "<h3>Tài khoản $email đã tồn tại! Không thể tạo thêm.</h3>";
} else {
    // 2. Mã hóa mật khẩu (Chuẩn bảo mật)
    // password_hash tạo ra một chuỗi ký tự ngẫu nhiên không thể dịch ngược
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
    
    // 3. Insert vào Database với role = 1 (Admin)
    $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 1)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$full_name, $email, $password_hashed])) {
        echo "<h2 style='color:green'>Tạo Admin thành công!</h2>";
        echo "<p>Email: <b>$email</b></p>";
        echo "<p>Mật khẩu: <b>$password_plain</b></p>";
        echo "<p>Role: <b>1 (Admin)</b></p>";
        echo "<br><a href='login.php'>Bấm vào đây để Đăng nhập</a>";
        echo "<br><br><b style='color:red'>LƯU Ý QUAN TRỌNG: Hãy xóa file setup_admin.php này ngay sau khi tạo xong!</b>";
    } else {
        echo "Có lỗi xảy ra khi tạo tài khoản.";
    }
}
?>