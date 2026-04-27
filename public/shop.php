<?php
session_start();

// 1. CẤU HÌNH TRANG
$page = 'shop';
$extraCss = 'assets/css/shop.css'; // Load CSS riêng

require_once '../config/db.php'; 

// ==================================================
// 2. LOGIC PHÂN TRANG (PAGINATION)
// ==================================================

// Số sản phẩm muốn hiện trên 1 trang
$limit = 12; 

// Lấy trang hiện tại từ URL (VD: shop.php?page=2), mặc định là 1
$page_curr = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page_curr < 1) $page_curr = 1;

// Tính vị trí bắt đầu lấy dữ liệu (OFFSET)
$start_from = ($page_curr - 1) * $limit;

try {
  // A. Đếm tổng số sản phẩm -> Tính tổng số trang
  $sql_count = "SELECT COUNT(*) FROM products";
  $stmt_count = $pdo->query($sql_count);
  $total_products = $stmt_count->fetchColumn();
  
  // Hàm ceil() để làm tròn lên (VD: 13 sp / 12 = 1.08 -> 2 trang)
  $total_pages = ceil($total_products / $limit);

  // B. Lấy danh sách sản phẩm cho trang hiện tại
  // Lưu ý: PDO LIMIT/OFFSET bắt buộc bind dạng INT
  $sql = "SELECT * FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
  $stmt->bindValue(':offset', $start_from, PDO::PARAM_INT);
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  $products = [];
  $total_pages = 0;
  // error_log($e->getMessage()); // Ghi log lỗi nếu cần
}

include '../includes/header.php'; 
?>

<section id="page-header">
  <h2>MUA SẮM NGAY BÂY GIỜ</h2>
  <p>Tiết kiệm hơn với mã giảm giá - giảm đến 50%!</p>
</section>

<section id="product1" class="section-p1">
  <div class="pro-container">
    
    <?php if (count($products) > 0): ?>
      
      <?php foreach ($products as $row): ?>
        <div class="pro" onclick="window.location.href='sproduct.php?id=<?php echo $row['id']; ?>';">
          
          <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
          
          <div class="des">
            <span>Cara</span>
            <h5><?php echo htmlspecialchars($row['name']); ?></h5>
            
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            
            <h4><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</h4>
          </div>
          
          <a href="#" onclick="event.stopPropagation(); addToCartQuick(<?php echo $row['id']; ?>)">
            <i class="fal fa-shopping-cart cart"></i>
          </a>
          
        </div>
      <?php endforeach; ?>

    <?php else: ?>
      <p style="width: 100%; text-align: center;">Hiện chưa có sản phẩm nào.</p>
    <?php endif; ?>

  </div>
</section>

<?php if ($total_pages > 1): ?>
  <section id="pagination" class="section-p1">
    
    <?php if ($page_curr > 1): ?>
      <a href="?page=<?php echo $page_curr - 1; ?>"><i class="fal fa-long-arrow-alt-left"></i></a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?php echo $i; ?>" 
         class="<?php echo ($i == $page_curr) ? 'active' : ''; ?>" 
         style="<?php echo ($i == $page_curr) ? 'background-color: #088178; color: #fff;' : ''; ?>">
         <?php echo $i; ?>
      </a>
    <?php endfor; ?>

    <?php if ($page_curr < $total_pages): ?>
      <a href="?page=<?php echo $page_curr + 1; ?>"><i class="fal fa-long-arrow-alt-right"></i></a>
    <?php endif; ?>

  </section>
<?php endif; ?>

<script>
  function addToCartQuick(id) {
    window.location.href = 'sproduct.php?id=' + id;
  }
</script>

<?php include '../includes/footer.php'; ?>