<?php
// Bài 6.2 - Trang chi tiết sản phẩm
session_start();
include("classtmdt/clskhachhang.php");
$p = new khachhang();

$idsp = isset($_GET['idsp']) ? $_GET['idsp'] : 0;
$chitietsanpham = $p->chitietsanpham($idsp);

$congty = $p->XemDSCongTy();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
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
        <!-- MENU TRÁI -->
        <aside class="menu">
            <h3>HÃNG</h3>
            <ul>
                <li><a href="index.php">Tất cả</a></li>
                <?php foreach ($congty as $ct): ?>
                <li><a href="index.php?idcty=<?= $ct['idcty'] ?>"><?= $ct['tencty'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- NỘI DUNG -->
        <div class="noidung">
            <?php if (empty($chitietsanpham)): ?>
                <p style="text-align:center;color:red;">Sản phẩm không tồn tại!</p>
            <?php else:
                $sp = $chitietsanpham[0];
                // Xử lý đặt hàng khi bấm nút
                if (isset($_POST['sbDathang'])) {
                    if (!isset($_SESSION['login'])) {
                        header("Location: login.php");
                        exit();
                    }
                    $idkhachhang = $_SESSION['id'];
                    $idsanpham   = $idsp;
                    $soluong     = $_POST['txtsoluong'];
                    $ngaydathang = date('Y-m-d H:i:s');

                    if ($idkhachhang != 0) {
                        // Tạo đơn hàng
                        $iddathang = $p->thucthisql(
                            "INSERT INTO dathang(idkh, ngaydathang, trangthai)
                             VALUES ('$idkhachhang','$ngaydathang','0')"
                        );

                        if ($iddathang) {
                            $dongia  = $p->laygiatritheodieukien("SELECT gia FROM sanpham WHERE idsp='$idsanpham' LIMIT 1");
                            $giamgia = $p->laygiatritheodieukien("SELECT giamgia FROM sanpham WHERE idsp='$idsanpham' LIMIT 1");

                            // Thêm chi tiết đơn hàng
                            $ok = $p->thucthisql(
                                "INSERT INTO dathang_chitiet(iddh, idsp, soluong, dongia, giamgia)
                                 VALUES ('$iddathang','$idsanpham','$soluong','$dongia','$giamgia')"
                            );

                            if ($ok) {
                                echo '<p class="msg-ok" style="text-align:center;">✅ Đặt hàng thành công! <a href="giohang.php">Xem giỏ hàng</a></p>';
                            } else {
                                echo '<p class="msg-err" style="text-align:center;">❌ Lỗi chi tiết đơn hàng.</p>';
                            }
                        } else {
                            echo '<p class="msg-err" style="text-align:center;">❌ Lỗi đặt hàng.</p>';
                        }
                    } else {
                        echo '<p class="msg-err" style="text-align:center;">Vui lòng đăng nhập trước.</p>';
                    }
                }
            ?>

            <!-- Bảng chi tiết sản phẩm -->
            <form method="post">
            <table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="3" align="center" valign="middle">
                        <strong>XEM CHI TIẾT SẢN PHẨM</strong>
                    </td>
                </tr>
                <tr>
                    <td width="215" rowspan="5" align="center" valign="middle">
                        <img src="img/<?= $sp['hinh'] ?>" width="200" height="198" alt="<?= $sp['tensp'] ?>">
                    </td>
                    <td width="95">Tên sản phẩm</td>
                    <td width="152"><?= $sp['tensp'] ?></td>
                </tr>
                <tr>
                    <td>Mô tả</td>
                    <td><?= $sp['mota'] ?></td>
                </tr>
                <tr>
                    <td>Giá</td>
                    <td><strong><?= number_format($sp['gia'],0,',','.') ?> USD</strong>
                        <?php if ($sp['giamgia'] > 0): ?>
                            <span style="color:red;"> (Giảm <?= $sp['giamgia'] ?>%)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Số lượng</td>
                    <td>
                        <input name="txtsoluong" id="txtsoluong" type="text" value="1" size="2">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center" valign="middle">
                        <input type="submit" name="sbDathang" id="sbDathang" value="Thêm Vào Giỏ Hàng" class="btn">
                        <a href="index.php" class="btn">Quay lại danh sách</a>
                    </td>
                </tr>
            </table>
            </form>

            <?php endif; ?>
        </div>
    </div>

    <footer>
        <a href="index.php">Footer Website - Bán Điện Thoại © 2024</a>
    </footer>
</div>
</body>
</html>
