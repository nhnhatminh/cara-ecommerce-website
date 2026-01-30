<?php
session_start();
require_once '../config/db.php';

// Check quyền Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="main-content">
    <header>
        <div style="display: flex; align-items: center;">
            <i class="fas fa-bars" id="menu-toggle" onclick="toggleSidebar()"></i>
            <div class="header-title">
                <h2 id="page-title">Tổng Quan</h2>
                <span id="current-date">Loading...</span>
            </div>
        </div>

        <div class="user-wrapper">
            <div class="user-profile">
                <div class="user-info" style="text-align: right;">
                    <h4><?php echo htmlspecialchars($_SESSION['user_name']); ?></h4>
                    <small>Administrator</small>
                </div>
            </div>
        </div>
    </header>

    <div id="dashboard" class="section-content active">
        <div class="cards">
            <div class="card-single">
                <div class="card-info"><h1 id="total-revenue">0 VND</h1><span>Doanh Thu</span></div>
                <div class="card-icon bg-1"><i class="fas fa-coins"></i></div>
            </div>
             <div class="card-single">
                <div class="card-info"><h1 id="total-orders">0</h1><span>Đơn Hàng</span></div>
                <div class="card-icon bg-2"><i class="fas fa-shopping-cart"></i></div>
            </div>
             <div class="card-single">
                <div class="card-info"><h1 id="total-products-count">0</h1><span>Sản Phẩm</span></div>
                <div class="card-icon bg-3"><i class="fas fa-box"></i></div>
            </div>
        </div>
        <div class="card-table">
            <div class="card-header">
                <h3>Đơn Hàng Mới Nhất</h3>
            </div>
            <table>
                <thead><tr><th>Mã ĐH</th><th>Khách Hàng</th><th>Tổng Tiền</th><th>Trạng Thái</th></tr></thead>
                <tbody id="recent-orders-body">
                    <tr><td colspan="4" style="text-align:center">Đang tải dữ liệu...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="products" class="section-content">
        <div class="card-table">
            <div class="card-header">
                <h3>Danh Sách Sản Phẩm</h3>
                <button class="btn-action" onclick="openProductModal()"><i class="fas fa-plus"></i> Thêm Mới</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên SP</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody id="product-list-body">
                    </tbody>
            </table>
        </div>
    </div>

    <div id="orders" class="section-content">
        <div class="card-table">
            <div class="card-header"><h3>Quản Lý Đơn Hàng</h3></div>
            <table>
                <thead><tr><th>Ngày</th><th>Khách</th><th>SĐT</th><th>Tiền</th><th>Trạng Thái</th><th>Hành Động</th></tr></thead>
                <tbody id="full-orders-body"></tbody>
            </table>
        </div>
    </div>
    
    <div id="customers" class="section-content">
        <div class="card-table">
            <div class="card-header">
                <h3>Danh Sách Khách Hàng</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Địa Chỉ</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody id="customer-list-body">
                    </tbody>
            </table>
        </div>
    </div>
    
    <div id="reviews" class="section-content">
        <h3>Đang phát triển...</h3>
    </div>

</div>

<div id="productModal" class="modal">
    <div class="modal-content" style="width: 600px;">
        <span class="close" onclick="closeProductModal()">&times;</span>
        <div class="card-header" style="border:none; padding:0; margin-bottom:10px;">
            <h3 id="modal-title">Thêm Sản Phẩm Mới</h3>
        </div>
        
        <form id="product-form" onsubmit="saveProduct(event)" enctype="multipart/form-data">
            <input type="hidden" id="p_id" name="id"> <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label style="font-weight:600; font-size:13px;">Tên sản phẩm:</label>
                    <input type="text" id="p_name" name="name" required style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px;">
                </div>
                <div style="flex: 1;">
                    <label style="font-weight:600; font-size:13px;">Giá bán (VND):</label>
                    <input type="number" id="p_price" name="price" required style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px;">
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label style="font-weight:600; font-size:13px;">Danh mục (Category ID):</label>
                    <select id="p_category" name="category_id" style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px;">
                        <option value="1">Áo sơ mi</option>
                        <option value="2">Quần tây</option>
                        <option value="3">Áo phông</option>
                        <option value="4">Phụ kiện</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="font-weight:600; font-size:13px;">Hình ảnh:</label>
                    <input type="file" id="p_image" name="image" accept="image/*" style="width:100%; padding:10px; margin:5px 0 15px;">
                </div>
            </div>
            
            <div id="preview-container" style="display:none; margin-bottom: 15px;">
                <img id="img-preview" src="" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px;">
                <small style="display:block; color:#888;">Ảnh hiện tại</small>
            </div>

            <label style="font-weight:600; font-size:13px;">Mô tả chi tiết:</label>
            <textarea id="p_desc" name="description" style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px; height:100px;"></textarea>

            <button type="submit" class="btn-action" style="width:100%; padding: 12px; font-size: 15px;">Lưu Sản Phẩm</button>
        </form>
    </div>
</div>

<div id="customerModal" class="modal">
    <div class="modal-content" style="width: 500px;">
        <span class="close" onclick="closeCustomerModal()">&times;</span>
        <div class="card-header" style="border:none; padding:0; margin-bottom:10px;">
            <h3>Chỉnh Sửa Thông Tin Khách Hàng</h3>
        </div>
        
        <form id="customer-form" onsubmit="saveCustomer(event)">
            <input type="hidden" id="c_id" name="id">
            
            <label style="font-weight:600; font-size:13px;">Họ tên:</label>
            <input type="text" id="c_fullname" name="full_name" required style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px;">
            
            <label style="font-weight:600; font-size:13px;">Email:</label>
            <input type="email" id="c_email" name="email" required style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px;">

            <label style="font-weight:600; font-size:13px;">Số điện thoại:</label>
            <input type="text" id="c_phone" name="phone" style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px;">

            <label style="font-weight:600; font-size:13px;">Địa chỉ:</label>
            <textarea id="c_address" name="address" style="width:100%; padding:10px; margin:5px 0 15px; border:1px solid #ddd; border-radius:5px; height:80px;"></textarea>

            <button type="submit" class="btn-action" style="width:100%; padding: 12px; font-size: 15px;">Lưu Thay Đổi</button>
        </form>
    </div>
</div>

<script src="js/product.js?v=<?php echo time(); ?>"></script>
<script src="js/customer.js?v=<?php echo time(); ?>"></script>


<?php include 'includes/footer.php'; ?>