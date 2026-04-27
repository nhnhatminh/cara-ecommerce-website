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
  // UI Navigation Logic 

  function switchTab(tabId, element) {
    // 1. Switch Content Section
    document.querySelectorAll('.section-content').forEach(el => el.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');

    // 2. Update Active Menu Item
    document.querySelectorAll('.sidebar-menu a').forEach(el => el.classList.remove('active'));
    if (element) element.classList.add('active');

    // 3. Update Page Title
    const titles = {
      'dashboard': 'Tổng Quan',
      'products': 'Quản Lý Sản Phẩm',
      'orders': 'Quản Lý Đơn Hàng',
      'customers': 'Khách Hàng',
      'reviews': 'Đánh Giá'
    };
    if (titles[tabId]) document.getElementById('page-title').innerText = titles[tabId];

    // 4. Auto-close sidebar on mobile
    if (window.innerWidth <= 768) toggleSidebar();
  }

  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
  }

  // Modal Logic

  function closeModal() {
    document.getElementById('replyModal').style.display = 'none';
  }

  // Initialization & Data Placeholders

  window.onload = function() {
    // Init Date Display
    document.getElementById('current-date').innerText = "Hôm nay: " + new Date().toLocaleDateString('vi-VN');

    // Load Default Dashboard
    switchTab('dashboard', document.querySelector('.sidebar-menu a.active'));
  };
</script>
</body>
</html>