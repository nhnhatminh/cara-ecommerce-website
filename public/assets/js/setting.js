// Chuyển Tab (Hồ sơ / Mật khẩu / Địa chỉ)
function switchTab(event, tabId) {
    event.preventDefault();

    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });

    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.classList.remove('active-tab');
    });

    document.getElementById(tabId).classList.add('active');
    event.currentTarget.classList.add('active-tab');
}

// Xem trước ảnh khi upload
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('avatar-preview').src = reader.result;
    }
    if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
}