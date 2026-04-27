<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cara Ecommerce</title>
  
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

  <?php 
  if (isset($extraCss)) {
    if (is_array($extraCss)) {
      foreach ($extraCss as $cssFile) {
        echo '<link rel="stylesheet" href="'.$cssFile.'">';
      }
    } else {
      echo '<link rel="stylesheet" href="'.$extraCss.'">';
    }
  } 
  ?>

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<body>
  
  <section id="header">
    
    <a href="index.php" class="logo-container">
      <img src="assets/img/logo.png" class="logo" alt="Cara Logo">
    </a>

    <div>
      <ul id="navbar">
        <li><a class="<?php echo ($page == 'home') ? 'active' : ''; ?>" href="index.php">Trang chủ</a></li>
        <li><a class="<?php echo ($page == 'shop') ? 'active' : ''; ?>" href="shop.php">Cửa hàng</a></li>
        <li><a class="<?php echo ($page == 'blog') ? 'active' : ''; ?>" href="blog.php">Blog</a></li>
        <li><a class="<?php echo ($page == 'about') ? 'active' : ''; ?>" href="about.php">Giới thiệu</a></li>
        <li><a class="<?php echo ($page == 'contact') ? 'active' : ''; ?>" href="contact.php">Liên hệ</a></li>
      </ul>
    </div>

    <div id="header-actions">
      
      <div class="user-box">
        <?php if(isset($_SESSION['user_id'])): ?>
          
          <div class="user-trigger">
            <i class="far fa-user user-icon"></i>
          </div>
          
          <div class="user-dropdown">
            <div class="dropdown-header">
              <strong>Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
            </div>
            <a href="setting.php"><i class="fas fa-cog"></i> Cài đặt tài khoản</a>
            <a href="setting.php?tab=orders"><i class="fas fa-box-open"></i> Đơn mua</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
          </div>

        <?php else: ?>
          
          <a href="login.php" title="Đăng nhập/Đăng ký">
            <i class="far fa-user user-icon"></i>
          </a>

        <?php endif; ?>
      </div>

      <a href="cart.php" class="cart-trigger" title="Giỏ hàng">
        <i class="far fa-shopping-bag"></i>
      </a>
      
      <i id="bar" class="fas fa-outdent"></i>
      
    </div>

  </section>