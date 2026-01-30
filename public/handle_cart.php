<?php
session_start();
require_once '../config/db.php';

// Cấu hình header JSON chuẩn
header('Content-Type: application/json');

function jsonResponse($status, $message, $data = []) {
    echo json_encode(array_merge(['status' => $status, 'message' => $message], $data));
    exit;
}

// Kiểm tra method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse('error', 'Invalid Request Method');
}

$action = $_POST['action'] ?? '';

// --- LOGIC XÓA (REMOVE) ---
if ($action === 'remove') {
    // Ép kiểu ID về số nguyên để trùng khớp với key trong mảng $_SESSION
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    // Debug: Kiểm tra xem Session có tồn tại không
    if (!isset($_SESSION['cart'])) {
        jsonResponse('error', 'Giỏ hàng đang trống (Session empty)');
    }

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]); // Xóa khỏi Session
        jsonResponse('success', 'Đã xóa sản phẩm ID: ' . $id);
    } else {
        jsonResponse('error', 'Không tìm thấy sản phẩm ID: ' . $id . ' trong giỏ hàng');
    }
}

// --- LOGIC UPDATE ---
if ($action === 'update') {
    $id = intval($_POST['id']);
    $qty = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$id])) {
        if ($qty > 0) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
            jsonResponse('success', 'Đã cập nhật số lượng');
        } else {
            unset($_SESSION['cart'][$id]);
            jsonResponse('success', 'Đã xóa sản phẩm do số lượng < 1');
        }
    } else {
        jsonResponse('error', 'Sản phẩm không tồn tại');
    }
}

// --- LOGIC ADD ---
if ($action === 'add') {
    $id = intval($_POST['id']);
    $qty = intval($_POST['quantity']);
    $size = $_POST['size'] ?? 'M';

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $qty,
                'size' => $size
            ];
        }
        jsonResponse('success', 'Đã thêm vào giỏ hàng');
    } else {
        jsonResponse('error', 'Sản phẩm không tồn tại');
    }
}
?>