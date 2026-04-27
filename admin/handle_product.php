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

// 1. LẤY DANH SÁCH SẢN PHẨM
if ($action === 'fetch') {
  $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode(['status' => 'success', 'data' => $products]);
  exit;
}

// 2. LẤY CHI TIẾT 1 SẢN PHẨM
if ($action === 'get_one') {
  $id = intval($_GET['id']);
  
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
  
  echo json_encode(['status' => 'success', 'data' => $product]);
  exit;
}

// 3. THÊM MỚI HOẶC CẬP NHẬT
if ($action === 'save') {
  $id = $_POST['id'] ?? '';
  $name = $_POST['name'];
  $price = $_POST['price'];
  $category_id = $_POST['category_id'];
  $desc = $_POST['description'];

  // Xử lý Upload Ảnh
  $imagePath = ''; 
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $uploadDir = '../public/assets/img/products/';
    
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fileName = 'prod_' . time() . '.' . $extension;
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      $imagePath = 'assets/img/products/' . $fileName;
    }
  }

  if ($id) {
    // UPDATE 
    $sql = "UPDATE products SET name=?, price=?, description=?, category_id=?";
    $params = [$name, $price, $desc, $category_id];

    if ($imagePath) {
      $sql .= ", image=?";
      $params[] = $imagePath;
    }
    
    $sql .= " WHERE id=?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
      echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công!']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Lỗi SQL Update']);
    }

  } else {
    // INSERT
    if (!$imagePath) $imagePath = 'assets/img/products/f1.jpg';

    $stmt = $pdo->prepare("INSERT INTO products (name, price, description, category_id, image) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$name, $price, $desc, $category_id, $imagePath])) {
      echo json_encode(['status' => 'success', 'message' => 'Thêm mới thành công!']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Lỗi SQL Insert']);
    }
  }
  exit;
}

// 4. XÓA SẢN PHẨM
if ($action === 'delete') {
  $id = $_POST['id'];
  $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
  
  if ($stmt->execute([$id])) {
    echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm!']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Không thể xóa']);
  }
  exit;
}
?>