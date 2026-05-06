<?php
// Bài 6.1 - Trang chủ: hiển thị sản phẩm + lọc theo công ty
include("classtmdt/clskhachhang.php");
$p = new khachhang();

// Lọc theo công ty nếu có
$idcty = isset($_GET['idcty']) ? $_GET['idcty'] : '';

$sanpham = $p->XemDSSanPham($idcty);
$congty  = $p->XemDSCongTy();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Bán Điện Thoại</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">

    <header>
        <h1>WEBSITE BÁN ĐIỆN THOẠI</h1>
        <a href="admin/admin.php">➕ THÊM SẢN PHẨM</a>
        <?php if (isset($_SESSION['login'])): ?>
            <a href="giohang.php">🛒 Giỏ hàng</a>
            <a href="logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="login.php">Đăng nhập</a>
            <a href="dangky.php">Đăng ký</a>
        <?php endif; ?>
    </header>

    <div class="main">

        <!-- MENU TRÁI: danh sách công ty -->
        <aside class="menu">
            <h3>HÃNG</h3>
            <ul>
                <li><a href="index.php" <?= $idcty=='' ? 'class="active"' : '' ?>>Tất cả</a></li>
                <?php foreach ($congty as $ct): ?>
                <li>
                    <a href="index.php?idcty=<?= $ct['idcty'] ?>"
                       <?= $idcty==$ct['idcty'] ? 'class="active"' : '' ?>>
                        <?= $ct['tencty'] ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- NỘI DUNG: danh sách sản phẩm -->
        <div class="noidung">
            <h3>SẢN PHẨM</h3>

            <?php if (empty($sanpham)): ?>
                <p style="text-align:center;color:gray;">Không có sản phẩm nào.</p>
            <?php else: ?>
                <?php foreach ($sanpham as $sp): ?>
                <div class="sanpham">
                    <a href="chitietsanpham.php?idsp=<?= $sp['idsp'] ?>">
                        <div class="hinh">
                            <img src="img/<?= $sp['hinh'] ?>" alt="<?= $sp['tensp'] ?>">
                        </div>
                        <div class="tensp"><?= $sp['tensp'] ?></div>
                        <div class="gia">Giá: <?= number_format($sp['gia'],0,',','.') ?> USD</div>
                    </a>
                </div>
                <?php endforeach; ?>
                <div style="clear:both;"></div>
            <?php endif; ?>

        </div><!-- end noidung -->
    </div><!-- end main -->

    <footer>
        <a href="index.php">Footer Website - Bán Điện Thoại © 2024</a>
    </footer>

</div><!-- end container -->
</body>
</html>
