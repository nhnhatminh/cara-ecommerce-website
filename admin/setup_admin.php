<?php
require_once '../config/db.php';

$full_name = "Minh Admin";
$email     = "admin@gmail.com";
$password  = "Admin@1234";

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
  echo "<h3 style='color:red'>Tài khoản $email đã tồn tại!</h3>";
} else {
  
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
  $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 1)";
  $stmt = $pdo->prepare($sql);
  
  if ($stmt->execute([$full_name, $email, $hashed_password])) {
    ?>
    <div style="font-family: sans-serif; line-height: 1.6; padding: 20px;">
      <h2 style="color:green">✔ Tạo Admin thành công!</h2>
      <ul>
        <li>Email: <b><?php echo $email; ?></b></li>
        <li>Password: <b><?php echo $password; ?></b></li>
        <li>Role: <b>Administrator (1)</b></li>
      </ul>
      
      <p>
        <a href="login.php" style="text-decoration:none; background:#088178; color:white; padding:10px 15px; border-radius:5px;">
          Đến trang Đăng nhập
        </a>
      </p>
      
      <hr>
    </div>
    <?php
  } else {
    echo "<h3>Lỗi: Không thể tạo tài khoản vào Database.</h3>";
  }
}
?>