/* public/assets/js/script.js */

// 1. Xử lý Menu Mobile (Bar & Close)
const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if (close) {
    close.addEventListener('click', (e) => {
        e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a
        nav.classList.remove('active');
    });
}

// 2. Hàm định dạng tiền tệ (Helper dùng chung cho toàn dự án nếu cần)
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}

