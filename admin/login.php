<?php
session_start();
require_once '../config/db.php';

// Nếu đã đăng nhập thì chuyển vào Dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Dùng email thay vì username cho chuẩn DB
    $password = $_POST['password'];

    // Query DB kiểm tra user có role = 1 (Admin)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Kiểm tra mật khẩu (Nếu bạn chưa mã hóa pass thì dùng so sánh thường, nếu có thì dùng password_verify)
        // Ví dụ so sánh thường (nếu DB bạn đang lưu plain text):
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Mật khẩu không đúng!";
        }
    } else {
        $error = "Tài khoản không tồn tại hoặc không có quyền Admin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Admin</title>
    <link rel="stylesheet" href="../public/assets/css/style.css"> <style>
        /* CSS riêng cho trang Login Admin */
        @import url('https://fonts.googleapis.com/css2?family=Spartan:wght@400;600;700&display=swap');
        body { background-color: #E3E6F3; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Spartan', sans-serif; }
        .login-container { background: #fff; width: 400px; padding: 40px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; }
        .login-container h2 { margin-bottom: 20px; color: #088178; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; outline: none; }
        .btn-login { width: 100%; background: #088178; color: #fff; padding: 12px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        .btn-login:hover { background: #066661; }
        .error { color: red; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>CARA ADMIN</h2>
        <?php if($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="admin@gmail.com">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required placeholder="Nhập mật khẩu">
            </div>
            <button type="submit" class="btn-login">Đăng Nhập</button>
        </form>
        <div style="margin-top: 20px; font-size: 13px;">
            <a href="../public/index.php" style="color: #555; text-decoration: none;">← Về trang chủ</a>
        </div>
    </div>
</body>
</html>