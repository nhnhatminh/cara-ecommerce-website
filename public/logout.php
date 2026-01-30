<?php
session_start(); // Khởi động session để biết đang hủy cái gì

// Xóa tất cả biến session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit;
?>