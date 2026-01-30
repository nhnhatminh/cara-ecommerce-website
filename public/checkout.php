<?php 
session_start();
require_once '../config/db.php';

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để thanh toán!'); window.location.href='login.php';</script>";
    exit;
}

// 2. Kiểm tra giỏ hàng rỗng
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href='shop.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];

// Tính tổng tiền lại (Backend verification)
$total_money = 0;
foreach ($cart as $item) {
    $total_money += $item['price'] * $item['quantity'];
}

// --- XỬ LÝ KHI BẤM NÚT ĐẶT HÀNG ---
if (isset($_POST['btn_order'])) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment'];

    try {
        $pdo->beginTransaction();

        // A. Insert vào bảng ORDERS
        $sql_order = "INSERT INTO orders (user_id, fullname, phone, address, total_money, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $pdo->prepare($sql_order);
        $stmt->execute([$user_id, $fullname, $phone, $address, $total_money, $payment_method]);
        $order_id = $pdo->lastInsertId();

        // B. Insert vào bảng ORDER_ITEMS
        $sql_item = "INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)";
        $stmt_item = $pdo->prepare($sql_item);

        foreach ($cart as $prod_id => $item) {
            $stmt_item->execute([$order_id, $prod_id, $item['name'], $item['price'], $item['quantity']]);
        }

        $pdo->commit();

        // C. Xóa giỏ hàng & Chuyển hướng
        unset($_SESSION['cart']);
        echo "<script>
            alert('Đặt hàng thành công! Mã đơn: #$order_id');
            window.location.href = 'index.php';
        </script>";
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
    }
}

$page = 'checkout';
$extraCss = 'assets/css/checkout.css';
include '../includes/header.php'; 
?>

<section class="section-p1">
    <form action="" method="POST">
        <div class="checkout-grid">
            
            <div class="checkout-left">
                <div class="checkout-step">
                    <h4 class="step-title">1. Thông tin giao hàng</h4>
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="fullname" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" placeholder="Số điện thoại nhận hàng" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea name="address" rows="3" required placeholder="Số nhà, đường..."></textarea>
                    </div>
                </div>

                <div class="checkout-step">
                    <h4 class="step-title" style="margin-top: 20px;">2. Thanh toán</h4>
                    <label class="payment-option">
                        <input type="radio" name="payment" value="COD" checked> 
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment" value="BANK"> 
                        <span>Chuyển khoản ngân hàng</span>
                    </label>
                </div>
            </div>

            <div class="checkout-right">
                <h3>Đơn hàng của bạn</h3>
                <div id="checkout-list" style="margin: 20px 0; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                    <?php foreach($cart as $item): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                            <span><?php echo $item['quantity']; ?>x <?php echo $item['name']; ?></span>
                            <span><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div style="display: flex; justify-content: space-between; font-size: 18px; margin-bottom: 20px;">
                    <strong>Tổng cộng:</strong>
                    <strong style="color: #E07C24;"><?php echo number_format($total_money, 0, ',', '.'); ?> VND</strong>
                </div>

                <button type="submit" name="btn_order" class="normal" style="width: 100%;">ĐẶT HÀNG NGAY</button>
            </div>
            
        </div>
    </form>
</section>

<?php include '../includes/footer.php'; ?>