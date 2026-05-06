<?php
session_start();
include("classtmdt/clskhachhang.php");
$p = new khachhang();

$msg = '';
if (isset($_POST['dangky'])) {
    $email     = $_POST['email'];
    $pass      = $_POST['password'];
    $hodem     = $_POST['hodem'];
    $ten       = $_POST['ten'];
    $diachi    = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];

    $ok = $p->dangky($email, $pass, $hodem, $ten, $diachi, $dienthoai);
    if ($ok) {
        header("Location: login.php");
        exit();
    } else {
        $msg = 'Đăng ký thất bại! Email có thể đã tồn tại.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">
    <header><h1>WEBSITE BÁN ĐIỆN THOẠI</h1></header>

    <div style="padding:20px;">
        <div class="form-wrap">
            <h2>ĐĂNG KÝ TÀI KHOẢN</h2>

            <?php if ($msg): ?>
                <p class="msg-err" style="text-align:center;"><?= $msg ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Họ đệm:</label>
                <input type="text" name="hodem" placeholder="Họ đệm" required>

                <label>Tên:</label>
                <input type="text" name="ten" placeholder="Tên" required>

                <label>Email:</label>
                <input type="email" name="email" placeholder="Email" required>

                <label>Mật khẩu:</label>
                <input type="password" name="password" placeholder="Mật khẩu" required>

                <label>Địa chỉ:</label>
                <input type="text" name="diachi" placeholder="Địa chỉ">

                <label>Số điện thoại:</label>
                <input type="text" name="dienthoai" placeholder="Số điện thoại">

                <button type="submit" name="dangky">Đăng ký</button>
            </form>

            <div class="link-bottom">
                <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                <p><a href="index.php">← Quay về trang chủ</a></p>
            </div>
        </div>
    </div>

    <footer><a href="index.php">Footer Website</a></footer>
</div>
</body>
</html>