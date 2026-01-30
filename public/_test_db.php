<?php
// 1. Gọi file cấu hình để kết nối
require_once '../config/db.php';

echo "<h1>KIỂM TRA KẾT NỐI DATABASE</h1>";

try {
    // Nếu code chạy đến đây mà không lỗi thì là kết nối thành công
    echo "<p style='color:green; font-weight:bold;'>✅ Kết nối MySQL thành công!</p>";
    
    // 2. Thử lấy dữ liệu Sản phẩm
    echo "<h3>Danh sách Sản phẩm:</h3>";
    $stmt = $pdo->query("SELECT id, name, price FROM products LIMIT 5");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($products) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Tên Sản Phẩm</th><th>Giá</th></tr>";
        foreach ($products as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . number_format($row['price']) . " VND</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red;'>Không tìm thấy sản phẩm nào (Kiểm tra lại lệnh INSERT).</p>";
    }

    // 3. Thử lấy dữ liệu Người dùng (Admin)
    echo "<h3>Tài khoản Admin:</h3>";
    $stmtUser = $pdo->query("SELECT full_name, email, role FROM users WHERE role = 1");
    $admin = $stmtUser->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "<ul>";
        echo "<li>Tên: " . $admin['full_name'] . "</li>";
        echo "<li>Email: " . $admin['email'] . "</li>";
        echo "</ul>";
    }

} catch (Exception $e) {
    echo "<p style='color:red; font-weight:bold;'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>