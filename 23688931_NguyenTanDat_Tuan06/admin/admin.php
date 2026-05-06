<?php
// Admin - Thêm sản phẩm
include("../classtmdt/clstmdt.php");
$p = new csdltmdt();

if (isset($_POST['btn'])) {
    $kq = $p->themsanpham(
        $_POST['congty'],
        $_POST['txtsp'],
        $_POST['txtgia'],
        $_POST['txtgiamgia'],
        $_POST['txtmota'],
        $_FILES['img']
    );
    if ($kq) {
        header("Location: ../index.php");
        exit();
    } else {
        $msg = "Thêm thất bại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Thêm Sản Phẩm</title>
    <link rel="stylesheet" href="../style/style.css">
<style>
.container { width: 560px; }
</style>
</head>
<body>
<div class="container">
    <header>
        <h1>ADMIN - THÊM SẢN PHẨM</h1>
        <a href="../index.php">← Về trang chủ</a>
    </header>

    <div style="padding:20px;">
        <?php if (!empty($msg)): ?>
            <p class="msg-err" style="text-align:center;"><?= $msg ?></p>
        <?php endif; ?>

        <div class="form-wrap">
            <h2>Thêm Sản Phẩm</h2>
            <form action="#" method="post" enctype="multipart/form-data">

                <label>Chọn công ty:</label>
                <?php $p->combobox("SELECT * FROM congty ORDER BY tencty ASC"); ?>

                <label>Tên sản phẩm:</label>
                <input type="text" name="txtsp" placeholder="Nhập tên sản phẩm" required>

                <label>Giá (USD):</label>
                <input type="text" name="txtgia" placeholder="Ví dụ: 199" required>

                <label>Giảm giá (%):</label>
                <input type="text" name="txtgiamgia" placeholder="Ví dụ: 10" value="0">

                <label>Mô tả:</label>
                <textarea name="txtmota" rows="4" placeholder="Nhập mô tả sản phẩm"></textarea>

                <label>Hình ảnh:</label>
                <input type="file" name="img" accept="image/*" required>

                <button type="submit" name="btn">➕ Thêm sản phẩm</button>
            </form>
        </div>
    </div>

    <footer><a href="../index.php">Footer Website</a></footer>
</div>
</body>
</html>