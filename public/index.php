<?php 
  session_start();
  // 1. Cấu hình & Kết nối Database
  $page = 'home';

  // Khai báo CSS riêng cho trang chủ
  $extraCss = 'assets/css/home.css';

  require_once '../config/db.php'; 

  // 2. Logic lấy dữ liệu từ Database

  // Lấy 8 Sản phẩm Nổi bật (Featured = 1)
  try {
      // Chỉ lấy 8 sản phẩm để hiển thị đẹp trên layout 4x2
      $sql_featured = "SELECT * FROM products WHERE featured = 1 LIMIT 8";
      $stmt_featured = $pdo->prepare($sql_featured);
      $stmt_featured->execute();
      $featured_products = $stmt_featured->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      $featured_products = [];
      // Ghi log lỗi nếu cần: error_log($e->getMessage());
  }

  // Lấy 8 Sản phẩm Mới nhất (Sắp xếp theo ngày tạo giảm dần)
  try {
      // Lấy những sản phẩm KHÔNG phải nổi bật, hoặc lấy tất cả sắp xếp theo mới nhất tùy bạn
      // Ở đây tôi lấy top 8 mới nhất bất kể nổi bật hay không
      $sql_new = "SELECT * FROM products ORDER BY created_at DESC LIMIT 8";
      $stmt_new = $pdo->prepare($sql_new);
      $stmt_new->execute();
      $new_products = $stmt_new->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      $new_products = [];
  }

  include '../includes/header.php'; 
  ?>

  <section id="hero">
    <h4>Chất lượng bền bỉ, chú trọng từng chi tiết</h4>
    <h2>ĐẾN VỚI CARA</h2>
    <h1>Trải nghiệm ngay</h1>
    <h1>Ưu đãi độc quyền</h1>
    <p>Tiết kiệm hơn với mã giảm giá - giảm đến 50%!</p>
    <button onclick="window.location.href='shop.php';">Mua ngay</button>
  </section>

  <section id="feature" class="section-p1">
    <div class="fe-box">
      <img src="assets/img/features/f1.png" alt="">
      <h6>Miễn phí Ship</h6>
    </div>
    <div class="fe-box">
      <img src="assets/img/features/f2.png" alt="">
      <h6>Đặt hàng Online</h6>
    </div>
    <div class="fe-box">
      <img src="assets/img/features/f3.png" alt="">
      <h6>Tiết kiệm</h6>
    </div>
    <div class="fe-box">
      <img src="assets/img/features/f4.png" alt="">
      <h6>Nhiều ưu đãi</h6>
    </div>
    <div class="fe-box">
      <img src="assets/img/features/f5.png" alt="">
      <h6>Mua sắm vui</h6>
    </div>
    <div class="fe-box">
      <img src="assets/img/features/f6.png" alt="">
      <h6>Hỗ trợ 24/7</h6>
    </div>
  </section>

  <section id="product1" class="section-p1">
    <h2>SẢN PHẨM NỔI BẬT</h2>
    <p>Thiết kế nghệ thuật - Sặc sỡ màu sắc</p>
    <div class="pro-container">
      
      <?php if (!empty($featured_products)): ?>
        <?php foreach ($featured_products as $product): ?>
            <div class="pro" onclick="window.location.href='sproduct.php?id=<?php echo $product['id']; ?>';">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div class="des">
                    <span>Cara</span>
                    <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Đang cập nhật sản phẩm nổi bật...</p>
      <?php endif; ?>

    </div>
  </section>

  <section id="banner" class="section-m1">
    <h4>Hỗ trợ - Bảo hành - Hoàn tiền</h4>
    <h2>Giảm đến <span>50%</span> - Tất cả sản phẩm</h2>
    <button class="normal" onclick="window.location.href='shop.php';">Xem chi tiết</button>
  </section>

  <section id="product1" class="section-p1">
    <h2>SẢN PHẨM MỚI</h2>
    <p>Thiết kế tối giản - Đơn sắc</p>
    <div class="pro-container">
      
      <?php if (!empty($new_products)): ?>
        <?php foreach ($new_products as $product): ?>
            <div class="pro" onclick="window.location.href='sproduct.php?id=<?php echo $product['id']; ?>';">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div class="des">
                    <span>Cara</span>
                    <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</h4>
                </div>
                <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Đang cập nhật sản phẩm mới...</p>
      <?php endif; ?>

    </div>
  </section>

  <section id="sm-banner" class="section-p1">
    <div class="banner-box">
      <h4>ưu đãi cực sốc</h4>
      <h2>Mua 1 Tặng 1</h2>
      <span>Những sản phẩm váy classic đang Sale đậm tại Cara</span>
      <button class="white">Xem chi tiết</button>
    </div>
    <div class="banner-box banner-box2">
      <h4>Xuân - Hè</h4>
      <h2>Sắp đến đây</h2>
      <span>Sản phẩm đậm chất Basic</span>
      <button class="white">Bộ sưu tập</button>
    </div>
  </section>

  <section id="banner3">
    <div class="banner-box">
      <h2>MÙA SALE CUỐI NĂM</h2>
      <h3>Bộ sưu tập Đông giảm 50%</h3>
    </div>
    <div class="banner-box banner-box2">
      <h2>BỘ SƯU TẬP GIÀY DÉP MỚI</h2>
      <h3>Xuân - Hè 2026</h3>
    </div>
    <div class="banner-box banner-box3">
      <h2>ÁO SƠ MI</h2>
      <h3>Họa tiết đơn sắc</h3>
    </div>
  </section>

  <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
      <h4>Đăng ký để trải nghiệm những ưu đãi tuyệt vời</h4>
      <p>Nhận thông tin cập nhật mới nhất về cửa hàng và <span>ưu đãi đặc biệt qua Email.</span>
      </p>
    </div>
    <div class="form">
      <input type="text" placeholder="Your email address">
      <button class="normal">Đăng ký ngay!</button>
    </div>
  </section>

<?php include '../includes/footer.php'; ?>