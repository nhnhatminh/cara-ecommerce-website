/* public/assets/js/script.js */

// 1. XỬ LÝ MENU MOBILE (TOGGLE)
const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

// Mở menu
if (bar) {
  bar.addEventListener('click', () => {
    nav.classList.add('active');
  });
}

// Đóng menu
if (close) {
  close.addEventListener('click', (e) => {
    e.preventDefault(); // Ngăn hành vi mặc định của thẻ <a>
    nav.classList.remove('active');
  });
}

// 2. HELPER: ĐỊNH DẠNG TIỀN TỆ (VND)
function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount);
}