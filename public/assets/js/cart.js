/* public/assets/js/cart.js */

console.log("=== CART.JS LOADED ===");

// 1. CẬP NHẬT SỐ LƯỢNG SẢN PHẨM
function updateCart(id, newQty) {
  // Kiểm tra đầu vào
  if (newQty < 1) {
    alert("Số lượng tối thiểu là 1");
    location.reload(); // Reset lại số cũ nếu nhập sai
    return;
  }

  // Chuẩn bị dữ liệu gửi đi
  let formData = new FormData();
  formData.append('action', 'update');
  formData.append('id', id);
  formData.append('quantity', newQty);

  // Gọi API xử lý
  fetch('handle_cart.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        location.reload(); // Load lại trang để cập nhật Tổng tiền
      } else {
        alert("Lỗi Server: " + data.message);
      }
    })
    .catch(err => console.error('Error:', err));
}

// 2. XÓA SẢN PHẨM KHỎI GIỎ
function removeFromCart(id) {
  console.log("Đang xóa sản phẩm ID:", id);

  if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
    let formData = new FormData();
    formData.append('action', 'remove');
    formData.append('id', id);

    fetch('handle_cart.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        // Kiểm tra HTTP Status trước
        if (!response.ok) {
          throw new Error("HTTP error " + response.status);
        }
        return response.json();
      })
      .then(data => {
        if (data.status === 'success') {
          // Xóa thành công -> Reload lại trang
          window.location.reload();
        } else {
          alert("Không thể xóa: " + data.message);
        }
      })
      .catch(err => {
        console.error('Lỗi kết nối:', err);
        alert("Có lỗi xảy ra khi gọi Server. Xem Console để biết chi tiết.");
      });
  }
}

// 3. KIỂM TRA ĐĂNG NHẬP KHI THANH TOÁN
function checkCheckout() {
  if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
    if (confirm("Bạn cần đăng nhập để thanh toán. Đi tới trang đăng nhập?")) {
      window.location.href = "login.php";
    }
  } else {
    window.location.href = "checkout.php";
  }
}