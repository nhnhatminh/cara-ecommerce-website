<footer class="section-p1">
  <div class="col">
    <img class="logo" src="assets/img/logo.png" alt="">
    <h4>Liên hệ</h4>
    <p><strong>Phone:</strong> 0956 677 705</p>
    <p><strong>Time:</strong> 09:00 - 20:00</p>
    <div class="follow">
      <h4>Theo dõi chúng tôi</h4>
      <div class="icon">
        <i class="fab fa-facebook-f"></i>
        <i class="fab fa-instagram"></i>
        <i class="fab fa-twitter"></i>
      </div>
    </div>
  </div>

  <div class="col">
    <h4>Giới thiệu</h4>
    <a href="#">Về chúng tôi</a>
    <a href="#">Thông tin giao hàng</a>
    <a href="#">Chính sách bảo mật</a>
    <a href="#">Điều khoản & Điều kiện</a>
    <a href="#">Liên hệ</a>
  </div>

  <div class="col">
    <h4>Tài khoản của tôi</h4>
    <a href="login.php">Đăng nhập</a>
    <a href="cart.php">Giỏ hàng</a>
    <a href="#">Danh sách yêu thích</a>
    <a href="#">Theo dõi đơn hàng</a>
    <a href="#">Hỗ trợ</a>
  </div>

  <div class="col install">
    <h4>Thanh toán Online</h4>
    <img src="assets/img/pay/pay.png" alt="">
  </div>

  <div class="copyright">
    <p>@ 2025, Nhóm 11 - HTML CSS Ecommerce</p>
  </div>
</footer>

<script src="assets/js/script.js"></script>

<script>
  // --- XỬ LÝ AUTHENTICATION (LOCAL STORAGE) ---

  const currentUser = localStorage.getItem('currentUser');
  const authBtn = document.getElementById('auth-btn');

  // 1. Kiểm tra trạng thái đăng nhập khi tải trang
  if (currentUser) {
    const user = JSON.parse(currentUser);
    // Thay nút Đăng nhập thành Tên user + Logout
    if (authBtn) {
      authBtn.innerHTML = `<a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> ${user.name}</a>`;
    }
  }

  // 2. Hàm Đăng xuất
  function logout() {
    if (confirm("Bạn có chắc muốn đăng xuất?")) {
      localStorage.removeItem('currentUser');
      window.location.href = "index.php";
    }
  }

  // 3. Chặn truy cập nếu chưa đăng nhập
  function checkLogin(e, targetUrl) {
    e.preventDefault();
    if (!currentUser) {
      if (confirm("Bạn cần đăng nhập để truy cập phần này. Đăng nhập ngay?")) {
        window.location.href = "login.php";
      }
    } else {
      window.location.href = targetUrl;
    }
  }
</script>
</body>
</html>