<?php 
session_start();
require_once '../config/db.php';

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";
$msg_type = ""; // success / error

// 2. Xử lý LOGOUT
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// 3. Xử lý CẬP NHẬT THÔNG TIN
if (isset($_POST['update_profile'])) {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    // $email = trim($_POST['email']); // Email thường không cho đổi để tránh lỗi hệ thống

    if (!empty($fullname)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET full_name = ?, phone = ? WHERE id = ?");
            if ($stmt->execute([$fullname, $phone, $user_id])) {
                $_SESSION['user_name'] = $fullname; // Cập nhật lại session
                $msg = "Cập nhật hồ sơ thành công!";
                $msg_type = "green";
            }
        } catch (PDOException $e) {
            $msg = "Lỗi: " . $e->getMessage();
            $msg_type = "red";
        }
    } else {
        $msg = "Tên không được để trống!";
        $msg_type = "red";
    }
}

// 4. Xử lý ĐỔI MẬT KHẨU
if (isset($_POST['change_pass'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($new_pass !== $confirm_pass) {
        $msg = "Mật khẩu xác nhận không khớp!";
        $msg_type = "red";
    } else {
        // Lấy pass cũ từ DB để so sánh
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $current_user = $stmt->fetch();

        if (password_verify($old_pass, $current_user['password'])) {
            // Hash mật khẩu mới và lưu
            $new_hashed = password_hash($new_pass, PASSWORD_DEFAULT);
            $stmtUpdate = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            if ($stmtUpdate->execute([$new_hashed, $user_id])) {
                $msg = "Đổi mật khẩu thành công!";
                $msg_type = "green";
            }
        } else {
            // Tạm thời hỗ trợ pass cũ chưa hash (cho user test cũ)
            if ($old_pass === $current_user['password']) {
                 $new_hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                 $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$new_hashed, $user_id]);
                 $msg = "Đổi mật khẩu thành công (Upgraded)!";
                 $msg_type = "green";
            } else {
                $msg = "Mật khẩu hiện tại không đúng!";
                $msg_type = "red";
            }
        }
    }
}

// 5. Lấy dữ liệu user mới nhất để hiển thị
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Cấu hình Header
$page = 'setting';
$extraCss = 'assets/css/setting.css';
include '../includes/header.php'; 
?>

<section id="profile-settings">
    <div class="setting-sidebar">
      <div class="avatar-container">
        <img src="assets/img/people/1.png" id="avatar-preview" alt="Avatar">
      </div>
      <h4 id="sidebar-name"><?php echo htmlspecialchars($user['full_name']); ?></h4>
      <p style="color: #888; font-size: 13px; margin-bottom: 10px;">Thành viên</p>
      
      <button class="btn-upload" onclick="alert('Tính năng upload ảnh đang phát triển')">
        <i class="fas fa-camera"></i> Đổi ảnh
      </button>

      <ul class="sidebar-menu">
        <li><a href="#" class="active-tab" onclick="switchTab(event, 'tab-info')"><i class="far fa-user"></i> Hồ sơ cá nhân</a></li>
        <li><a href="#" onclick="switchTab(event, 'tab-password')"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
        <li><a href="#" onclick="switchTab(event, 'tab-address')"><i class="fas fa-map-marker-alt"></i> Sổ địa chỉ</a></li>
        <li><a href="?action=logout" style="color: red;"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
      </ul>
    </div>

    <div class="setting-content">
      
      <?php if($msg != ""): ?>
        <div style="padding: 10px; margin-bottom: 20px; border-radius: 4px; background-color: <?php echo ($msg_type=='green') ? '#d4edda' : '#f8d7da'; ?>; color: <?php echo ($msg_type=='green') ? '#155724' : '#721c24'; ?>;">
            <?php echo $msg; ?>
        </div>
      <?php endif; ?>

      <div id="tab-info" class="tab-content active">
        <h3>Hồ sơ của tôi</h3>
        <form action="" method="POST">
            <div class="form-group">
              <label>Tên hiển thị</label>
              <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-group">
              <label>Số điện thoại</label>
              <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Chưa cập nhật">
            </div>
            <div class="form-group">
              <label>Email (Không thể thay đổi)</label>
              <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly style="background-color: #f0f0f0;">
            </div>
            <button type="submit" name="update_profile" class="btn-save">Lưu thay đổi</button>
        </form>
      </div>

      <div id="tab-password" class="tab-content">
        <h3>Đổi mật khẩu </h3>
        <form action="" method="POST">
            <div class="form-group">
              <label>Mật khẩu hiện tại</label>
              <input type="password" name="old_pass" required>
            </div>
            <div class="form-group">
              <label>Mật khẩu mới</label>
              <input type="password" name="new_pass" required>
            </div>
            <div class="form-group">
              <label>Xác nhận mật khẩu mới</label>
              <input type="password" name="confirm_pass" required>
            </div>
            <button type="submit" name="change_pass" class="btn-save">Cập nhật mật khẩu</button>
        </form>
      </div>

      <div id="tab-address" class="tab-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e1e1e1; padding-bottom: 15px;">
          <h3 style="border: none; margin: 0;">Địa chỉ của tôi</h3>
          <button class="btn-save" style="padding: 8px 15px; font-size: 14px;" onclick="alert('Chức năng thêm địa chỉ đang phát triển')"><i class="fas fa-plus"></i> Thêm mới</button>
        </div>

        <?php if (!empty($user['address'])): ?>
            <div class="address-item">
              <h5><?php echo htmlspecialchars($user['full_name']); ?> <span class="badge-default">Mặc định</span></h5>
              <p><?php echo htmlspecialchars($user['phone'] ?? 'Chưa có SĐT'); ?></p>
              <p><?php echo htmlspecialchars($user['address']); ?></p>
              <i class="fas fa-trash-alt btn-delete-addr"></i>
            </div>
        <?php else: ?>
            <p>Bạn chưa lưu địa chỉ nào.</p>
        <?php endif; ?>
      </div>

    </div>
</section>

<script src="assets/js/setting.js"></script>

<?php include '../includes/footer.php'; ?>