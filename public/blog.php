<?php 
session_start();
$page = 'blog'; // Active menu Blog
include '../includes/header.php'; 
?>

<style>
  /* Blog Header Banner */
  #blog-header {
    background-image: url("assets/img/banner/b19.jpg");
    width: 100%;
    height: 40vh;
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
    position: relative;
  }
  
  #blog-header::after {
    content: "";
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4);
  }

  #blog-header h2, #blog-header p {
    position: relative;
    z-index: 2;
    color: #fff;
  }

  #blog-header h2 { font-size: 40px; font-weight: 800; margin-bottom: 10px; }
  #blog-header p { font-size: 18px; font-weight: 300; letter-spacing: 1px; }

  /* Filter Buttons */
  .blog-filter {
    display: flex;
    justify-content: center;
    gap: 15px;
    padding: 40px 80px 20px 80px;
    flex-wrap: wrap;
  }

  .filter-btn {
    padding: 10px 25px;
    border: 1px solid #e1e1e1;
    border-radius: 30px;
    background: #fff;
    color: #1a1a1a;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
  }

  .filter-btn:hover, .filter-btn.active {
    background: var(--primary-color);
    color: #fff;
    border-color: var(--primary-color);
  }

  /* Blog Grid System */
  #blog-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    padding: 40px 80px;
  }

  /* Blog Card Style */
  .blog-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: 0.3s;
    display: flex;
    flex-direction: column;
  }

  .blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
  }

  .blog-thumb {
    width: 100%;
    height: 250px;
    overflow: hidden;
    position: relative;
  }

  .blog-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s;
  }

  .blog-card:hover .blog-thumb img {
    transform: scale(1.1);
  }

  .blog-date-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #fff;
    padding: 5px 15px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
  }

  .blog-info {
    padding: 25px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }

  .blog-category {
    color: var(--primary-color);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .blog-info h4 {
    font-size: 20px;
    margin-bottom: 15px;
    line-height: 1.4;
    color: #1a1a1a;
    font-weight: 700;
    transition: 0.3s;
  }
  
  .blog-card:hover h4 { color: var(--primary-color); }

  .blog-info p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
  }

  .read-more-link {
    text-decoration: none;
    color: #1a1a1a;
    font-weight: 700;
    font-size: 14px;
    position: relative;
    width: fit-content;
  }

  .read-more-link::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: -4px;
    left: 0;
    background: var(--primary-color);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
  }

  .read-more-link:hover::after {
    transform: scaleX(1);
    transform-origin: left;
  }

  /* Responsive */
  @media (max-width: 799px) {
    #blog-container { padding: 40px 20px; grid-template-columns: 1fr; }
    .blog-filter { padding: 20px; }
    #blog-header h2 { font-size: 30px; }
  }
</style>

<section id="blog-header">
  <h2>CARA JOURNAL</h2>
  <p>Cảm hứng thời trang & Phong cách sống</p>
</section>

<section class="blog-filter">
  <button class="filter-btn active" data-filter="all">Tất cả</button>
  <button class="filter-btn" data-filter="trend">Xu Hướng</button>
  <button class="filter-btn" data-filter="tips">Phối Đồ</button>
  <button class="filter-btn" data-filter="tech">Công Nghệ</button>
</section>

<section id="blog-container">
  
  <div class="blog-card">
    <div class="blog-thumb">
      <span class="blog-date-badge">13/01/2026</span>
      <img src="assets/img/blog/b1.jpg" alt="">
    </div>
    <div class="blog-info">
      <span class="blog-category">Xu Hướng</span>
      <h4>Những set đồ Hoodie Zip ấm áp cho mùa Đông</h4>
      <p>Khám phá bộ sưu tập áo Hoodie chất liệu nỉ bông dày dặn, items không thể thiếu trong tủ đồ của giới trẻ năm nay...</p>
      <a href="#" class="read-more-link">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <div class="blog-card">
    <div class="blog-thumb">
      <span class="blog-date-badge">10/01/2026</span>
      <img src="assets/img/blog/b2.jpg" alt="">
    </div>
    <div class="blog-info">
      <span class="blog-category">Mix & Match</span>
      <h4>Phong cách Minimalist: Ít hơn là nhiều hơn</h4>
      <p>Năm 2026 đánh dấu sự trở lại mạnh mẽ của phong cách tối giản. Các gam màu trung tính như Be, Trắng, Xám tiếp tục lên ngôi...</p>
      <a href="#" class="read-more-link">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <div class="blog-card">
    <div class="blog-thumb">
      <span class="blog-date-badge">05/01/2026</span>
      <img src="assets/img/blog/b3.jpg" alt="">
    </div>
    <div class="blog-info">
      <span class="blog-category">Lifestyle</span>
      <h4>Cara ra mắt bộ sưu tập phụ kiện giới hạn</h4>
      <p>Không chỉ quần áo, Cara mang đến bộ sưu tập túi xách và giày sneaker phiên bản giới hạn dành riêng cho các thành viên VIP...</p>
      <a href="#" class="read-more-link">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <div class="blog-card">
    <div class="blog-thumb">
      <span class="blog-date-badge">01/01/2026</span>
      <img src="assets/img/blog/b4.jpg" alt="">
    </div>
    <div class="blog-info">
      <span class="blog-category">Công Nghệ</span>
      <h4>Công nghệ vải thoáng khí Air-Cool mới</h4>
      <p>Áp dụng công nghệ dệt mới giúp thấm hút mồ hôi tối đa, phù hợp cho cả hoạt động thể thao cường độ cao và dạo phố...</p>
      <a href="#" class="read-more-link">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <div class="blog-card">
    <div class="blog-thumb">
      <span class="blog-date-badge">28/12/2025</span>
      <img src="assets/img/blog/b6.jpg" alt="">
    </div>
    <div class="blog-info">
      <span class="blog-category">Xu Hướng</span>
      <h4>Màu Pastel - Sự lựa chọn ngọt ngào</h4>
      <p>Màu pastel nhẹ nhàng luôn là sự lựa chọn hoàn hảo cho những ngày hè năng động. Cùng khám phá bảng màu mới nhất tại Cara.</p>
      <a href="#" class="read-more-link">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <div class="blog-card">
    <div class="blog-thumb">
      <span class="blog-date-badge">24/12/2025</span>
      <img src="assets/img/banner/b10.jpg" alt="">
    </div>
    <div class="blog-info">
      <span class="blog-category">Sự Kiện</span>
      <h4>Tổng kết Fashion Week 2025</h4>
      <p>Điểm lại những bộ cánh ấn tượng nhất tuần lễ thời trang vừa qua và dự đoán xu hướng cho năm mới.</p>
      <a href="#" class="read-more-link">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

</section>

<section id="pagination" class="section-p1">
  <a href="#">1</a>
  <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
</section>

<script>
  const btns = document.querySelectorAll('.filter-btn');
  btns.forEach(btn => {
    btn.addEventListener('click', function() {
      btns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

<?php include '../includes/footer.php'; ?>