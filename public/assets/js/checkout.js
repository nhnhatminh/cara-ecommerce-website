/* public/assets/js/checkout.js */

// 1. TẢI THÔNG TIN GIỎ HÀNG (TỪ LOCALSTORAGE)
function loadCheckout() {
  // Lấy dữ liệu giỏ hàng
  let cart = localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [];

  const listContainer = document.getElementById("checkout-list");
  const totalElement = document.getElementById("checkout-total");
  const cartInput = document.getElementById("cart-data"); // Input ẩn gửi về PHP

  let total = 0;
  listContainer.innerHTML = "";

  // Xử lý trường hợp giỏ hàng trống
  if (cart.length === 0) {
    listContainer.innerHTML = "<p style='text-align:center;'>Giỏ hàng trống</p>";
    totalElement.innerText = "0 VND";
    return;
  }

  // Render danh sách sản phẩm
  cart.forEach(item => {
    let subtotal = item.price * item.quantity;
    total += subtotal;

    let itemHTML = `
      <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
        <div>
          <span style="font-weight:600;">${item.name}</span><br>
          <span style="color: #888; font-size: 12px;">Size: ${item.size} x ${item.quantity}</span>
        </div>
        <span>${subtotal.toLocaleString()} VND</span>
      </div>
    `;
    listContainer.innerHTML += itemHTML;
  });

  // Cập nhật Tổng tiền hiển thị
  totalElement.innerText = total.toLocaleString() + " VND";

  // Quan trọng: Đổ dữ liệu JSON vào input ẩn để Form PHP nhận được
  if (cartInput) {
    cartInput.value = JSON.stringify(cart);
  }
}

// Gọi hàm khi trang tải xong
window.onload = loadCheckout;

// 2. KIỂM TRA TRƯỚC KHI SUBMIT ĐƠN HÀNG
function validateOrder(event) {
  let cart = localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [];

  if (cart.length === 0) {
    alert("Giỏ hàng đang trống! Vui lòng chọn sản phẩm trước khi thanh toán.");
    event.preventDefault(); // Chặn gửi form
    return false;
  }
  return true;
}