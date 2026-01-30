<div id="replyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="card-header" style="border:none; padding:0; margin-bottom:10px;">
                <h3>Trả lời đánh giá</h3>
            </div>
            <p id="review-content-display" style="margin-bottom: 15px; color: #555; background: #f9f9f9; padding: 10px; border-radius: 5px; font-style: italic;"></p>
            <textarea id="reply-text" placeholder="Nhập nội dung trả lời..."></textarea>
            <input type="hidden" id="current-review-id">
            <button class="btn-action" onclick="saveReply()">Gửi Trả Lời</button>
        </div>
    </div>

    <script>
        // Hàm chuyển Tab
        function switchTab(tabId, element) {
            // Ẩn tất cả section
            document.querySelectorAll('.section-content').forEach(el => el.classList.remove('active'));
            // Hiện section được chọn
            document.getElementById(tabId).classList.add('active');
            
            // Xử lý active menu
            document.querySelectorAll('.sidebar-menu a').forEach(el => el.classList.remove('active'));
            if(element) element.classList.add('active');
            
            // Đổi tên tiêu đề
            const titles = { 'dashboard': 'Tổng Quan', 'products': 'Quản Lý Sản Phẩm', 'orders': 'Quản Lý Đơn Hàng', 'customers': 'Khách Hàng', 'reviews': 'Đánh Giá' };
            if(titles[tabId]) document.getElementById('page-title').innerText = titles[tabId];
            
            // Mobile toggle
            if(window.innerWidth <= 768) toggleSidebar();
        }

        function toggleSidebar() { document.getElementById('sidebar').classList.toggle('active'); }

        // Modal Logic
        function closeModal() { document.getElementById('replyModal').style.display = 'none'; }
        
        // --- CÁC HÀM XỬ LÝ DỮ LIỆU (TẠM THỜI ĐỂ TRỐNG HOẶC GIỮ NGUYÊN) ---
        // Sau này chúng ta sẽ viết lại các hàm loadProducts(), loadOrders() bằng AJAX gọi PHP
        // Hiện tại bạn có thể giữ nguyên file JS cũ của bạn ở đây nếu muốn demo chạy ngay, 
        // nhưng tôi khuyến nghị sẽ viết lại logic lấy dữ liệu từ Database ở bước sau.
        
        window.onload = function() {
            // Hiển thị ngày tháng
            document.getElementById('current-date').innerText = "Hôm nay: " + new Date().toLocaleDateString('vi-VN');
            
            // Tạm thời gọi dashboard
            switchTab('dashboard', document.querySelector('.sidebar-menu a.active'));
        };
    </script>
</body>
</html>