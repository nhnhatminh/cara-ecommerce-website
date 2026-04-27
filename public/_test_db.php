<?php
// 1. GỌI FILE CẤU HÌNH
require_once '../config/db.php';

echo "<h1>KIỂM TRA KẾT NỐI DATABASE</h1>";

try {
  // Nếu không văng lỗi ở dòng require trên thì kết nối đã OK
  echo "<p style='color:green; font-weight:bold;'>✅ Kết nối MySQL thành công!</p>";
  
  // 2. LẤY DỮ LIỆU SẢN PHẨM (TEST)
  echo "<h3>Danh sách Sản phẩm (5 cái đầu):</h3>";
  
  $stmt = $pdo->query("SELECT id, name, price FROM products LIMIT 5");
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($products) {
    echo "<table border='1' cellpadding='10' style='border-collapse:collapse; width:50%;'>";
    echo "<tr style='background:#eee;'><th>ID</th><th>Tên Sản Phẩm</th><th>Giá</th></tr>";
    
    foreach ($products as $row) {
      echo "<tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>{$row['name']}</td>";
      echo "<td>" . number_format($row['price']) . " VND</td>";
      echo "</tr>";
    }
    
    echo "</table>";
  } else {
    echo "<p style='color:red;'>Không tìm thấy sản phẩm nào (Hãy kiểm tra lại lệnh INSERT).</p>";
  }

  // 3. KIỂM TRA TÀI KHOẢN ADMIN
  echo "<h3>Tài khoản Admin:</h3>";
  
  $stmtUser = $pdo->query("SELECT full_name, email, role FROM users WHERE role = 1 LIMIT 1");
  $admin = $stmtUser->fetch(PDO::FETCH_ASSOC);
  
  if ($admin) {
    echo "<ul>";
    echo "<li>Tên: <b>{$admin['full_name']}</b></li>";
    echo "<li>Email: <b>{$admin['email']}</b></li>";
    echo "<li>Role: <b>{$admin['role']}</b></li>";
    echo "</ul>";
  } else {
    echo "<p style='color:orange;'>Chưa có tài khoản Admin nào.</p>";
  }

} catch (Exception $e) {
  // Bắt lỗi kết nối
  echo "<p style='color:red; font-weight:bold;'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>