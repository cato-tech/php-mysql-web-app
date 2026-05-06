<?php
// Bài 6.4 - Quản lý giỏ hàng
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include("classtmdt/clskhachhang.php");
$p = new khachhang();

$idkh    = $_SESSION['id'];
$giohang = $p->giohang($idkh);
$congty  = $p->XemDSCongTy();

// Xác nhận đặt hàng (trangthai 0 → 1)
if (isset($_POST['sbxacnhandathang']) && $_POST['sbxacnhandathang'] == 'Xác nhận đặt hàng') {
    $ok = $p->thucthisql(
        "UPDATE dathang SET trangthai='1'
         WHERE idkh='$idkh' AND trangthai='0'"
    );
    echo $ok ? '<p class="msg-ok" style="text-align:center;">✅ Đã xác nhận đặt hàng!</p>'
             : '<p class="msg-err" style="text-align:center;">❌ Lỗi xác nhận.</p>';
    // Reload giỏ hàng
    $giohang = $p->giohang($idkh);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">

    <header>
        <h1>WEBSITE BÁN ĐIỆN THOẠI</h1>
        <a href="index.php">🏠 Trang chủ</a>
        <a href="giohang.php">🛒 Giỏ hàng</a>
        <a href="lichsumhang.php">📋 Lịch sử mua hàng</a>
        <a href="logout.php">Đăng xuất (<?= $_SESSION['ten'] ?? '' ?>)</a>
    </header>

    <div class="main">
        <aside class="menu">
            <h3>HÃNG</h3>
            <ul>
                <li><a href="index.php">Tất cả</a></li>
                <?php foreach ($congty as $ct): ?>
                <li><a href="index.php?idcty=<?= $ct['idcty'] ?>"><?= $ct['tencty'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <div class="noidung">
            <h3>GIỎ HÀNG</h3>

            <?php if (empty($giohang)): ?>
                <p style="text-align:center;color:gray;">Giỏ hàng trống. <a href="index.php">Mua sắm ngay</a></p>
            <?php else: ?>
            <form method="post">
            <table width="800" border="1" align="center" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="9" align="center" valign="middle"><strong>GIỎ HÀNG</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>STT</strong></td>
                    <td align="center"><strong>Mã đơn</strong></td>
                    <td align="center"><strong>Ngày đặt</strong></td>
                    <td align="center"><strong>Sản phẩm</strong></td>
                    <td align="center"><strong>Số lượng</strong></td>
                    <td align="center"><strong>Đơn giá</strong></td>
                    <td align="center"><strong>Giảm giá</strong></td>
                    <td align="center"><strong>Trạng thái</strong></td>
                    <td align="center"><strong>Thay đổi</strong></td>
                </tr>

                <?php
                $tongthanhtien = 0;
                foreach ($giohang as $i => $gh):
                    $tensp = $p->laygiatritheodieukien(
                        "SELECT tensp FROM sanpham WHERE idsp='" . $gh['idsp'] . "' LIMIT 1"
                    );
                    $thanhtien = ($gh['soluong'] * $gh['dongia']) - ($gh['soluong'] * $gh['giamgia']);
                    $tongthanhtien += $thanhtien;
                ?>
                <tr>
                    <td align="center"><?= $i + 1 ?></td>
                    <td align="left"><?= $gh['iddh'] ?></td>
                    <td align="left"><?= $gh['ngaydathang'] ?></td>
                    <td align="left"><?= $tensp ?></td>
                    <td align="left"><?= $gh['soluong'] ?></td>
                    <td align="left"><?= number_format($gh['dongia'],0,',','.') ?></td>
                    <td align="left"><?= $gh['giamgia'] ?>%</td>
                    <td align="left"><?= $gh['trangthai'] == 0 ? 'Chờ duyệt' : 'Đã xác nhận' ?></td>
                    <td align="center">
                        <a href="capnhatdonhang.php?id=<?= $gh['iddh'] ?>" class="btn">Sửa</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="9" align="center" valign="middle">
                        <strong>Tổng thành tiền: <?= number_format($tongthanhtien,0,',','.') ?> USD</strong>
                        &nbsp;&nbsp;
                        <input type="submit" name="sbxacnhandathang"
                               value="Xác nhận đặt hàng" class="btn">
                    </td>
                </tr>
            </table>
            </form>
            <?php endif; ?>

        </div>
    </div>

    <footer><a href="index.php">Footer Website - Bán Điện Thoại © 2024</a></footer>
</div>
</body>
</html>