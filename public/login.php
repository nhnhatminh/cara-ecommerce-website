<?php
session_start();
require_once '../config/db.php';

// 1. KIỂM TRA ĐĂNG NHẬP
if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

$error_msg = "";
$success_msg = "";
$active_panel = ""; // Class CSS để điều khiển Slider (rỗng = Login, right-panel-active = Register)

// ==================================================
// LOGIC ĐĂNG KÝ (REGISTER)
// ==================================================
if (isset($_POST['register'])) {
  $full_name = trim($_POST['full_name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  
  // Giữ lại panel đăng ký nếu có reload trang
  $active_panel = "right-panel-active"; 

  // A. Kiểm tra email tồn tại
  $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->execute([$email]);
  
  if ($stmt->rowCount() > 0) {
    $error_msg = "Email này đã được sử dụng!";
  } else {
    // B. Hash mật khẩu và tạo user mới (Role 0 = Khách)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
      $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 0)");
      if ($stmt->execute([$full_name, $email, $hashed_password])) {
        $success_msg = "Đăng ký thành công! Vui lòng đăng nhập.";
        $active_panel = ""; // Đăng ký xong -> Chuyển về panel Login
      }
    } catch (PDOException $e) {
      $error_msg = "Lỗi hệ thống: " . $e->getMessage();
    }
  }
}

// ==================================================
// LOGIC ĐĂNG NHẬP (LOGIN)
// ==================================================
if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    // Kiểm tra mật khẩu (Hỗ trợ cả Hash mới và Plain text cũ)
    if (password_verify($password, $user['password']) || $password === $user['password']) {
      
      // Lưu Session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['full_name'];
      $_SESSION['user_role'] = $user['role'];
      $_SESSION['user_email'] = $user['email'];

      echo "<script>alert('Đăng nhập thành công!'); window.location.href='index.php';</script>";
      exit;
    } else {
      $error_msg = "Mật khẩu không đúng!";
    }
  } else {
    $error_msg = "Email chưa được đăng ký!";
  }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Nhập - Cara Ecommerce</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>

  <div class="container <?php echo $active_panel; ?>" id="container">
    
    <div class="form-container sign-up-container">
      <form action="login.php" method="POST">
        <h1>Tạo Tài Khoản</h1>
        
        <div class="social-container">
          <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google"></i></a>
        </div>
        
        <span>hoặc sử dụng email để đăng ký</span>
        
        <input type="text" name="full_name" placeholder="Họ và Tên" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Mật khẩu" required />
        
        <?php if ($active_panel != "" && $error_msg != ""): ?>
          <p style="color: red; margin: 5px 0; font-size: 13px;"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <button type="submit" name="register">Đăng Ký</button>
      </form>
    </div>

    <div class="form-container sign-in-container">
      <form action="login.php" method="POST">
        <h1>Đăng Nhập</h1>
        
        <div class="social-container">
          <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google"></i></a>
        </div>
        
        <span>hoặc sử dụng tài khoản của bạn</span>
        
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Mật khẩu" required />
        
        <a href="#" id="forgotPass" style="margin: 10px 0; font-size: 12px; color: #333;">Quên mật khẩu?</a>
        
        <?php if ($active_panel == "" && $error_msg != ""): ?>
          <p style="color: red; margin: 5px 0; font-size: 13px;"><?php echo $error_msg; ?></p>
        <?php endif; ?>
        
        <?php if ($success_msg != ""): ?>
          <p style="color: green; margin: 5px 0; font-size: 13px;"><?php echo $success_msg; ?></p>
        <?php endif; ?>

        <button type="submit" name="login">Đăng Nhập</button>
        <a href="index.php" class="back-home"><i class="fas fa-arrow-left"></i> Quay về Trang chủ</a>
      </form>
    </div>

    <div class="overlay-container">
      <div class="overlay">
        
        <div class="overlay-panel overlay-left">
          <h1>Chào mừng trở lại!</h1>
          <p>Để tiếp tục kết nối với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
          <button class="ghost" id="signIn">Đăng Nhập</button>
        </div>
        
        <div class="overlay-panel overlay-right">
          <h1>Xin chào, Bạn mới!</h1>
          <p>Nhập thông tin cá nhân và bắt đầu hành trình mua sắm cùng Cara</p>
          <button class="ghost" id="signUp">Đăng Ký</button>
        </div>
        
      </div>
    </div>
    
  </div>

  <script src="assets/js/auth.js"></script>

</body>
</html>