/* public/assets/js/setting.js */

// 1. CHUYỂN TAB (Hồ sơ / Mật khẩu / Địa chỉ)
function switchTab(event, tabId) {
  event.preventDefault();

  // Reset trạng thái hiển thị nội dung
  document.querySelectorAll('.tab-content').forEach(content => {
    content.classList.remove('active');
  });

  // Reset trạng thái active của menu
  document.querySelectorAll('.sidebar-menu a').forEach(link => {
    link.classList.remove('active-tab');
  });

  // Kích hoạt tab và menu được chọn
  document.getElementById(tabId).classList.add('active');
  event.currentTarget.classList.add('active-tab');
}

// 2. XEM TRƯỚC ẢNH KHI UPLOAD
function previewImage(event) {
  const reader = new FileReader();

  reader.onload = function() {
    document.getElementById('avatar-preview').src = reader.result;
  }

  if (event.target.files[0]) {
    reader.readAsDataURL(event.target.files[0]);
  }
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    if (tab === 'orders') {
        switchTab(null, 'tab-orders');
    } else {
        switchTab(null, 'tab-info');
    }
});