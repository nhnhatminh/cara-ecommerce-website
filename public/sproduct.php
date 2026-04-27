<?php 
session_start();
require_once '../config/db.php'; 

// 1. KHỞI TẠO BIẾN
$product = null;
$related_products = [];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. LẤY DỮ LIỆU TỪ DB
if ($id > 0) {
  try {
    // A. Lấy thông tin sản phẩm hiện tại
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // B. Lấy 4 sản phẩm liên quan (Cùng Category, trừ sản phẩm hiện tại)
    if ($product) {
      $stmtRelated = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4");
      $stmtRelated->execute([$product['category_id'], $id]);
      $related_products = $stmtRelated->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    // error_log($e->getMessage());
  }
}

// 3. XỬ LÝ NẾU KHÔNG TÌM THẤY SẢN PHẨM
if (!$product) {
  echo "<script>alert('Sản phẩm không tồn tại!'); window.location.href='shop.php';</script>";
  exit;
}

// 4. CẤU HÌNH HEADER
$page = 'shop';
$extraCss = 'assets/css/sproduct.css?v=' . time(); // Cache busting
include '../includes/header.php'; 
?>

<section id="prodetails" class="section-p1">
  
  <div class="single-pro-image">
    <img src="<?php echo htmlspecialchars($product['image']); ?>" width="100%" id="MainImg" alt="Product Image">
    
    </div>

  <div class="single-pro-details">
    <h6><a href="shop.php" style="text-decoration:none; color:inherit;">Cửa hàng</a> / Chi tiết sản phẩm</h6>
    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
    <h2><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</h2>
    
    <select id="pro-size">
      <option value="Default">Chọn Size</option>
      <option value="S">Size S</option>
      <option value="M">Size M</option>
      <option value="L">Size L</option>
      <option value="XL">Size XL</option>
    </select>
    
    <div class="btn-group">
      <input type="number" value="1" min="1" id="pro-qty">
      <button class="btn-add" data-id="<?php echo $product['id']; ?>">Thêm Vào Giỏ</button>
    </div>
    
    <h4>Mô Tả Sản Phẩm</h4>
    <span><?php echo nl2br(htmlspecialchars($product['description'])); ?></span>
  </div>

</section>

<section id="product1" class="section-p1">
  <h2>Sản Phẩm Liên Quan</h2>
  <p>Có thể bạn cũng thích những mẫu này</p>
  
  <div class="pro-container">
    <?php if (!empty($related_products)): ?>
      <?php foreach ($related_products as $rel_prod): ?>
        <div class="pro" onclick="window.location.href='sproduct.php?id=<?php echo $rel_prod['id']; ?>';">
          <img src="<?php echo htmlspecialchars($rel_prod['image']); ?>" alt="">
          <div class="des">
            <span>Cara</span>
            <h5><?php echo htmlspecialchars($rel_prod['name']); ?></h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4><?php echo number_format($rel_prod['price'], 0, ',', '.'); ?> VND</h4>
          </div>
          <a href="sproduct.php?id=<?php echo $rel_prod['id']; ?>"><i class="fal fa-shopping-cart cart"></i></a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Không có sản phẩm liên quan nào.</p>
    <?php endif; ?>
  </div>
</section>

<script src="assets/js/sproduct.js?v=<?php echo time(); ?>"></script>

<?php include '../includes/footer.php'; ?>