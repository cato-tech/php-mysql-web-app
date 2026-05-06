<?php
/**
 * auth_admin.php
 * Include file này ở ĐẦU mọi trang trong thư mục admin/
 * Nếu chưa đăng nhập admin → chuyển về admin_login.php
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: ../admin_login.php");
    exit();
}
?>