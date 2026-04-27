<?php
session_start();
require_once '../config/db.php';

// 1. CẤU HÌNH HEADER JSON
header('Content-Type: application/json');

/**
 * Helper: Trả về phản hồi JSON và kết thúc script
 */
function jsonResponse($status, $message, $data = []) {
  echo json_encode(array_merge(['status' => $status, 'message' => $message], $data));
  exit;
}

// 2. KIỂM TRA REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  jsonResponse('error', 'Invalid Request Method');
}

$action = $_POST['action'] ?? '';

// ==================================================
// ACTION: REMOVE (XÓA SẢN PHẨM)
// ==================================================
if ($action === 'remove') {
  // Ép kiểu ID về số nguyên để khớp key mảng
  $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
  
  // Kiểm tra Session tồn tại
  if (!isset($_SESSION['cart'])) {
    jsonResponse('error', 'Giỏ hàng đang trống');
  }

  if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]); // Xóa khỏi Session
    jsonResponse('success', 'Đã xóa sản phẩm ID: ' . $id);
  } else {
    jsonResponse('error', 'Không tìm thấy sản phẩm ID: ' . $id);
  }
}

// ==================================================
// ACTION: UPDATE (CẬP NHẬT SỐ LƯỢNG)
// ==================================================
if ($action === 'update') {
  $id = intval($_POST['id']);
  $qty = intval($_POST['quantity']);

  if (isset($_SESSION['cart'][$id])) {
    if ($qty > 0) {
      $_SESSION['cart'][$id]['quantity'] = $qty;
      jsonResponse('success', 'Đã cập nhật số lượng');
    } else {
      // Nếu số lượng <= 0 thì xóa luôn
      unset($_SESSION['cart'][$id]);
      jsonResponse('success', 'Đã xóa sản phẩm do số lượng < 1');
    }
  } else {
    jsonResponse('error', 'Sản phẩm không tồn tại trong giỏ');
  }
}

// ==================================================
// ACTION: ADD (THÊM VÀO GIỎ)
// ==================================================
if ($action === 'add') {
  $id = intval($_POST['id']);
  $qty = intval($_POST['quantity']);
  $size = $_POST['size'] ?? 'M';

  // Lấy thông tin sản phẩm từ DB để đảm bảo chính xác (Giá, Tên)
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product) {
    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }
    
    // Logic thêm hoặc cộng dồn
    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['quantity'] += $qty;
    } else {
      $_SESSION['cart'][$id] = [
        'name'     => $product['name'],
        'price'    => $product['price'],
        'image'    => $product['image'],
        'quantity' => $qty,
        'size'     => $size
      ];
    }
    jsonResponse('success', 'Đã thêm vào giỏ hàng');
  } else {
    jsonResponse('error', 'Sản phẩm không tồn tại trong Database');
  }
}
?>