<?php 
session_start();
require_once '../config/db.php';

// 1. KIỂM TRA ĐĂNG NHẬP
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. KIỂM TRA ID ĐƠN HÀNG
if (!isset($_GET['id'])) {
    header("Location: setting.php?tab=orders");
    exit;
}

$order_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// 3. LẤY THÔNG TIN ĐƠN HÀNG (Phải khớp cả order_id và user_id để bảo mật)
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<script>alert('Đơn hàng không tồn tại hoặc bạn không có quyền xem!'); window.location.href='setting.php?tab=orders';</script>";
    exit;
}

// 4. LẤY CHI TIẾT SẢN PHẨM TRONG ĐƠN
$stmtItems = $pdo->prepare("
    SELECT oi.*, p.image 
    FROM order_items oi 
    LEFT JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmtItems->execute([$order_id]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

// Helper function trạng thái
function getStatusBadge($status) {
    switch ($status) {
        case 0: return '<span style="color:red; font-weight:bold;">Đã hủy</span>';
        case 1: return '<span style="color:#e6b800; font-weight:bold;">Chờ xử lý</span>';
        case 2: return '<span style="color:blue; font-weight:bold;">Đang giao hàng</span>';
        case 3: return '<span style="color:green; font-weight:bold;">Giao thành công</span>';
        default: return 'Không xác định';
    }
}

$page = 'order_details';
include '../includes/header.php'; 
?>

<style>
    /* CSS nội bộ cho trang chi tiết đơn hàng */
    #order-details { padding: 40px 80px; }
    .order-header { border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-end; }
    .order-info h3 { color: #088178; margin-bottom: 5px; }
    .order-meta { color: #555; line-height: 1.6; font-size: 15px; }
    
    .table-details { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .table-details th { background: #f8f9fa; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; }
    .table-details td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; }
    .table-details img { width: 70px; border-radius: 5px; }
    
    .total-section { display: flex; justify-content: flex-end; margin-top: 20px; }
    .total-box { width: 300px; border: 1px solid #e1e1e1; padding: 20px; border-radius: 5px; }
    .total-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
    .final-price { font-size: 20px; color: #088178; font-weight: bold; }
    
    .btn-back { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #088178; color: white; text-decoration: none; border-radius: 4px; }
    .btn-back:hover { background: #066661; }

    @media (max-width: 799px) { #order-details { padding: 20px; } .order-header { flex-direction: column; align-items: flex-start; gap: 15px; } }
</style>

<section id="order-details">
    <div class="order-header">
        <div class="order-info">
            <h3>Chi tiết đơn hàng #<?php echo $order['id']; ?></h3>
            <div class="order-meta">
                Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?> <br>
                Trạng thái: <?php echo getStatusBadge($order['status']); ?> <br>
                Phương thức thanh toán: <?php echo htmlspecialchars($order['payment_method']); ?>
            </div>
        </div>
        <div class="shipping-info" style="text-align: right; min-width: 300px;">
            <strong>Thông tin giao hàng:</strong> <br>
            <?php echo htmlspecialchars($order['fullname']); ?> <br>
            <?php echo htmlspecialchars($order['phone']); ?> <br>
            <span style="color:#666; font-size: 14px;"><?php echo htmlspecialchars($order['address']); ?></span>
        </div>
    </div>

    <table class="table-details">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Tạm tính</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
            ?>
            <tr>
                <td style="display: flex; align-items: center; gap: 15px;">
                    <img src="<?php echo htmlspecialchars($item['image'] ?? 'assets/img/products/f1.jpg'); ?>" alt="">
                    <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                </td>
                <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                <td>x<?php echo $item['quantity']; ?></td>
                <td style="font-weight: 600;"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-box">
            <div class="total-row">
                <span>Tạm tính:</span>
                <span><?php echo number_format($order['total_money'], 0, ',', '.'); ?>đ</span>
            </div>
            <div class="total-row">
                <span>Phí vận chuyển:</span>
                <span>0đ</span> </div>
            <div style="border-top: 1px solid #ddd; margin: 10px 0;"></div>
            <div class="total-row">
                <strong>Tổng cộng:</strong>
                <span class="final-price"><?php echo number_format($order['total_money'], 0, ',', '.'); ?>đ</span>
            </div>
        </div>
    </div>

    <a href="setting.php?tab=orders" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
</section>

<?php include '../includes/footer.php'; ?>