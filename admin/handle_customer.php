<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

// Check quyền Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// 1. LẤY DANH SÁCH KHÁCH HÀNG (FETCH)
if ($action === 'fetch') {
    // Chỉ lấy những user không phải là Admin (role != 1)
    $stmt = $pdo->query("SELECT id, full_name, email, phone, address, created_at FROM users WHERE role != 1 ORDER BY id DESC");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $customers]);
    exit;
}

// 2. LẤY 1 KHÁCH HÀNG (GET ONE)
if ($action === 'get_one') {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT id, full_name, email, phone, address FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $customer]);
    exit;
}

// 3. CẬP NHẬT THÔNG TIN (UPDATE)
if ($action === 'save') {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Kiểm tra email trùng lặp (trừ chính user đó ra)
    $stmtCheck = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmtCheck->execute([$email, $id]);
    if ($stmtCheck->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Email này đã được sử dụng bởi người khác!']);
        exit;
    }

    $sql = "UPDATE users SET full_name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$full_name, $email, $phone, $address, $id])) {
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi SQL Update']);
    }
    exit;
}

// 4. XÓA KHÁCH HÀNG (DELETE)
if ($action === 'delete') {
    $id = $_POST['id'];
    
    // (Tùy chọn: Có thể kiểm tra xem khách này có đơn hàng không trước khi xóa)
    // Ở đây xóa thẳng
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['status' => 'success', 'message' => 'Đã xóa khách hàng!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không thể xóa']);
    }
    exit;
}
?>