<?php
// Bài 6.3 - Đăng nhập (yêu cầu đăng nhập trước khi đặt hàng)
session_start();
include("classtmdt/clskhachhang.php");
$p = new khachhang();

$msg = '';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $kh = $p->dangnhap($email, $pass);
    if ($kh) {
        $_SESSION['login'] = true;
        $_SESSION['id']    = $kh['idkh'];
        $_SESSION['ten']   = $kh['hodem'] . ' ' . $kh['ten'];
        // Quay lại trang trước hoặc về index
        $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : 'index.php';
        unset($_SESSION['redirect']);
        header("Location: $redirect");
        exit();
    } else {
        $msg = 'Sai email hoặc mật khẩu!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">
    <header><h1>WEBSITE BÁN ĐIỆN THOẠI</h1></header>

    <div style="padding:20px;">
        <div class="form-wrap">
            <h2>ĐĂNG NHẬP</h2>

            <?php if ($msg): ?>
                <p class="msg-err" style="text-align:center;"><?= $msg ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Email:</label>
                <input type="email" name="email" placeholder="Nhập email" required>

                <label>Mật khẩu:</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu" required>

                <button type="submit" name="login">Đăng nhập</button>
            </form>

            <div class="link-bottom">
                <p>Chưa có tài khoản? <a href="dangky.php">Đăng ký ngay</a></p>
                <p><a href="index.php">← Quay về trang chủ</a></p>
            </div>

            <!-- LINK ĐĂNG NHẬP ADMIN -->
            <div style="margin-top:18px; padding-top:14px; border-top:1px solid #ddd; text-align:center;">
                <p style="font-size:13px; color:#888; margin-bottom:6px;">Bạn là quản trị viên?</p>
                <a href="admin/admin_login.php"
                   style="display:inline-block; padding:8px 20px; background:#2c3e50; color:white;
                          border-radius:5px; text-decoration:none; font-size:13px; font-weight:bold;">
                    ⚙️ Đăng nhập Admin
                </a>
            </div>

        </div>
    </div>

    <footer><a href="index.php">Footer Website</a></footer>
</div>
</body>
</html>