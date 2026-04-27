<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

// CHECK QUYỀN ADMIN
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] != 1) {
  echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
  exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// 1. LẤY DANH SÁCH ĐƠN HÀNG 
if ($action === 'fetch') {
    $sql = "SELECT * FROM orders ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['status' => 'success', 'data' => $orders]);
    exit;
}

// 2. LẤY CHI TIẾT ĐƠN HÀNG 
if ($action === 'get_details') {
    $order_id = intval($_GET['id']);

    // Lấy thông tin chung
    $stmtOrder = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmtOrder->execute([$order_id]);
    $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng']);
        exit;
    }

    // Lấy danh sách sản phẩm
    $stmtItems = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmtItems->execute([$order_id]);
    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success', 
        'data' => [
            'order_info' => $order,
            'items' => $items
        ]
    ]);
    exit;
}

// 3. CẬP NHẬT TRẠNG THÁI 
if ($action === 'update_status') {
    $order_id = $_POST['id'];
    $status = intval($_POST['status']); 
    // Status quy ước: 0: Hủy, 1: Mới, 2: Đang giao, 3: Hoàn thành

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $order_id])) {
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi SQL Update']);
    }
    exit;
}

// 4. THỐNG KÊ DASHBOARD 
if ($action === 'stats') {
    // Tổng doanh thu 
    $stmtRevenue = $pdo->query("SELECT SUM(total_money) as total FROM orders WHERE status != 0");
    $revenue = $stmtRevenue->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Tổng số đơn hàng
    $stmtOrders = $pdo->query("SELECT COUNT(*) as total FROM orders");
    $totalOrders = $stmtOrders->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Tổng số sản phẩm
    $stmtProducts = $pdo->query("SELECT COUNT(*) as total FROM products");
    $totalProducts = $stmtProducts->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    echo json_encode([
        'status' => 'success',
        'revenue' => number_format($revenue, 0, ',', '.') . ' VND',
        'orders' => $totalOrders,
        'products' => $totalProducts
    ]);
    exit;
}
?>