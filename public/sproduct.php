<?php 
session_start();
require_once '../config/db.php'; 

$product = null;
$related_products = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $stmtRelated = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4");
            $stmtRelated->execute([$product['category_id'], $id]);
            $related_products = $stmtRelated->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {}
}

if (!$product) {
    echo "<script>alert('Sản phẩm không tồn tại!'); window.location.href='shop.php';</script>";
    exit;
}

$page = 'shop';
// Thêm tham số time() để xóa cache CSS ngay lập tức
$extraCss = 'assets/css/sproduct.css?v=' . time();
include '../includes/header.php'; 
?>

<section id="prodetails" class="section-p1">
    <div class="single-pro-image">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" width="100%" id="MainImg" alt="">
    </div>

    <div class="single-pro-details">
        <h6>Trang Chủ / Sản Phẩm</h6>
        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
        <h2><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</h2>
        
        <select id="pro-size">
            <option>Chọn Size</option>
            <option>Size S</option>
            <option>Size M</option>
            <option>Size L</option>
        </select>
        
        <div class="btn-group">
            <input type="number" value="1" min="1" id="pro-qty">
            <button class="btn-add" data-id="<?php echo $product['id']; ?>">Thêm Vào Giỏ</button>
        </div>
        
        <h4>Mô Tả Sản Phẩm</h4>
        <span><?php echo nl2br(htmlspecialchars($product['description'])); ?></span>
    </div>
</section>

<script src="assets/js/sproduct.js?v=<?php echo time(); ?>"></script>

<?php include '../includes/footer.php'; ?>