/* admin/js/product.js */

document.addEventListener("DOMContentLoaded", function() {
  // Tải danh sách nếu bảng tồn tại
  if (document.getElementById('product-list-body')) {
    loadProducts();
  }
});

// 1. TẢI DANH SÁCH SẢN PHẨM
function loadProducts() {
  fetch('handle_product.php?action=fetch')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const tbody = document.getElementById('product-list-body');
        tbody.innerHTML = '';

        // Cập nhật bộ đếm trên Dashboard
        if (document.getElementById('total-products-count')) {
          document.getElementById('total-products-count').innerText = data.data.length;
        }

        // Render dữ liệu ra bảng
        data.data.forEach(p => {
          let row = `
            <tr>
              <td><img src="../public/${p.image}" class="product-img"></td>
              <td style="font-weight:600;">${p.name}</td>
              <td>${parseInt(p.price).toLocaleString()} VND</td>
              <td>ID: ${p.category_id}</td>
              <td>
                <div class="action-group">
                  <button class="btn-action btn-edit" onclick="openProductModal(${p.id})">
                    <i class="fas fa-edit"></i> Sửa
                  </button>
                  <button class="btn-action btn-delete" onclick="deleteProduct(${p.id})">
                    <i class="fas fa-trash"></i> Xóa
                  </button>
                </div>
              </td>
            </tr>
          `;
          tbody.innerHTML += row;
        });
      }
    });
}

// 2. MỞ MODAL
function openProductModal(id = null) {
  const modal = document.getElementById('productModal');
  const form = document.getElementById('product-form');
  const title = document.getElementById('modal-title');
  const preview = document.getElementById('preview-container');

  // Reset form
  form.reset();
  preview.style.display = 'none';

  if (id) {
    // Chế độ SỬA: Lấy dữ liệu cũ
    title.innerText = "Chỉnh Sửa Sản Phẩm";
    document.getElementById('p_id').value = id;

    fetch(`handle_product.php?action=get_one&id=${id}`)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          const p = data.data;
          document.getElementById('p_name').value = p.name;
          document.getElementById('p_price').value = p.price;
          document.getElementById('p_category').value = p.category_id;
          document.getElementById('p_desc').value = p.description;

          // Hiện ảnh cũ
          document.getElementById('img-preview').src = "../public/" + p.image;
          preview.style.display = 'block';
        }
      });
  } else {
    // Chế độ THÊM MỚI
    title.innerText = "Thêm Sản Phẩm Mới";
    document.getElementById('p_id').value = "";
  }

  modal.style.display = 'flex';
}

function closeProductModal() {
  document.getElementById('productModal').style.display = 'none';
}

// 3. LƯU SẢN PHẨM (Ajax Upload)
function saveProduct(e) {
  e.preventDefault();

  const form = document.getElementById('product-form');
  const formData = new FormData(form);
  formData.append('action', 'save');

  // Hiệu ứng Loading
  const btn = form.querySelector('button[type="submit"]');
  const originalText = btn.innerText;
  btn.innerText = "Đang lưu...";
  btn.disabled = true;

  fetch('handle_product.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        alert(data.message);
        closeProductModal();
        loadProducts();
      } else {
        alert("Lỗi: " + data.message);
      }
    })
    .catch(err => alert("Lỗi kết nối server"))
    .finally(() => {
      btn.innerText = originalText;
      btn.disabled = false;
    });
}

// 4. XÓA SẢN PHẨM
function deleteProduct(id) {
  if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('handle_product.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          loadProducts();
        } else {
          alert("Lỗi: " + data.message);
        }
      });
  }
}