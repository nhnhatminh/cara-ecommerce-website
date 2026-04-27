/* public/assets/js/sproduct.js */

document.addEventListener("DOMContentLoaded", function() {

  // Tìm nút thêm giỏ hàng
  const btnAdd = document.querySelector('.btn-add');

  if (btnAdd) {
    btnAdd.addEventListener('click', function() {

      // 1. LẤY DỮ LIỆU ĐẦU VÀO
      const productId = this.getAttribute('data-id');
      const qtyInput = document.getElementById('pro-qty');
      const sizeSelect = document.getElementById('pro-size');

      let quantity = qtyInput ? parseInt(qtyInput.value) : 1;
      let size = sizeSelect ? sizeSelect.value : 'Default';

      // Validate số lượng
      if (quantity < 1 || isNaN(quantity)) {
        alert("Số lượng phải lớn hơn 0");
        return;
      }

      // 2. HIỆU ỨNG LOADING (UX)
      let originalText = this.innerText;
      this.innerText = "Đang xử lý...";
      this.disabled = true;

      // 3. GỬI DỮ LIỆU SANG PHP (AJAX)
      let formData = new FormData();
      formData.append('action', 'add');
      formData.append('id', productId);
      formData.append('quantity', quantity);
      formData.append('size', size);

      fetch('handle_cart.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert("✅ " + data.message);
            // Có thể reload trang nếu muốn cập nhật số lượng trên Header ngay lập tức
            // location.reload();
          } else {
            alert("❌ Lỗi: " + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert("Lỗi kết nối Server!");
        })
        .finally(() => {
          // 4. KHÔI PHỤC TRẠNG THÁI NÚT
          this.innerText = originalText;
          this.disabled = false;
        });
    });
  }
});