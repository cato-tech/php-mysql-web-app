<?php
/**
 * admin_logout.php  –  Đăng xuất Admin
 * Đặt tại thư mục gốc
 */
session_start();
// Chỉ xóa session admin, giữ nguyên session khách hàng nếu có
unset($_SESSION['admin_login']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_ten']);

header("Location: admin_login.php");
exit();
?>