<?php 
session_start();
$page = 'cart';
// Ép tải lại CSS
$extraCss = 'assets/css/cart.css?v=' . rand(1000, 9999);
include '../includes/header.php'; 

// Lấy giỏ hàng
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
?>

<section id="page-header">
    <h2>GIỎ HÀNG</h2>
    <p>Kiểm tra lại các sản phẩm yêu thích của bạn</p>
</section>

<section id="cart" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Xóa</td>
                <td>Hình ảnh</td>
                <td>Sản phẩm</td>
                <td>Giá</td>
                <td>Số lượng</td>
                <td>Tạm tính</td>
            </tr>
        </thead>
        <tbody id="cart-body-php"> 
            <?php if (!empty($cart)): ?>
                <?php foreach ($cart as $id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total_price += $subtotal;
                ?>
                <tr>
                    <td>
                        <a href="javascript:void(0);" onclick="removeFromCart(<?php echo $id; ?>)">
                            <i class="far fa-times-circle"></i>
                        </a>
                    </td>
                    
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt=""></td>
                    
                    <td>
                        <?php echo htmlspecialchars($item['name']); ?> <br>
                        <?php if(isset($item['size'])): ?>
                            <span style="font-size: 12px; color: #888;">Size: <?php echo $item['size']; ?></span>
                        <?php endif; ?>
                    </td>
                    
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                    
                    <td>
                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1" 
                               onchange="updateCart(<?php echo $id; ?>, this.value)">
                    </td>
                    
                    <td><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px;">
                        <strong>Giỏ hàng trống!</strong>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<section id="cart-add" class="section-p1">
    <div id="subtotal">
        <h3>Tổng Giỏ Hàng</h3>
        <table>
            <tr>
                <td><strong>Tổng cộng</strong></td>
                <td><strong><?php echo number_format($total_price, 0, ',', '.'); ?> VND</strong></td>
            </tr>
        </table>
        <?php if (!empty($cart)): ?>
            <button class="normal" onclick="checkCheckout()">Tiến hành thanh toán</button>
        <?php endif; ?>
    </div>
</section>

<script>
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
</script>

<script src="assets/js/cart.js?v=<?php echo rand(1000, 9999); ?>"></script>

<?php include '../includes/footer.php'; ?>