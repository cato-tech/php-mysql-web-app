<?php
// Bài 6.4 - Cập nhật số lượng / xóa sản phẩm trong giỏ hàng
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include("classtmdt/clskhachhang.php");
$p = new khachhang();

$iddh = isset($_GET['id']) ? $_GET['id'] : 0;
$idsp = $p->laygiatritheodieukien(
    "SELECT idsp FROM dathang_chitiet WHERE iddh='$iddh' LIMIT 1"
);

$msg = '';

// Cập nhật số lượng
if (isset($_POST['sbcapnhat']) && $_POST['sbcapnhat'] == 'Cập nhật đơn hàng') {
    $soluong = $_POST['txtsoluong'];
    $ok = $p->thucthisql(
        "UPDATE dathang_chitiet SET soluong='$soluong' WHERE iddh='$iddh' LIMIT 1"
    );
    $msg = $ok ? '<span class="msg-ok">✅ Cập nhật thành công.</span>'
               : '<span class="msg-err">❌ Cập nhật không thành công.</span>';
}

// Xóa đơn hàng
if (isset($_POST['sbxoa']) && $_POST['sbxoa'] == 'Xóa đơn hàng') {
    $ok = $p->thucthisql(
        "DELETE FROM dathang_chitiet WHERE iddh='$iddh' LIMIT 1"
    );
    if ($ok) {
        // Xóa luôn dathang nếu không còn chi tiết
        $p->thucthisql("DELETE FROM dathang WHERE iddh='$iddh' LIMIT 1");
        header("Location: giohang.php");
        exit();
    }
    $msg = '<span class="msg-err">❌ Xóa thất bại.</span>';
}

// Cập nhật địa chỉ nhận hàng
if (isset($_POST['sbcapnhatdiachinhanhang']) && $_POST['sbcapnhatdiachinhanhang'] == 'Cập nhật địa chỉ nhận hàng') {
    $idkh           = $_SESSION['id'];
    $diachinhanhang = $_POST['txtdiachinhanhang'];
    $ok = $p->thucthisql(
        "UPDATE khachhang SET diachinhanhang='$diachinhanhang' WHERE idkh='$idkh' LIMIT 1"
    );
    $msg = $ok ? '<span class="msg-ok">✅ Cập nhật địa chỉ thành công.</span>'
               : '<span class="msg-err">❌ Cập nhật không thành công.</span>';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Đơn Hàng</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">

    <header>
        <h1>WEBSITE BÁN ĐIỆN THOẠI</h1>
        <a href="index.php">🏠 Trang chủ</a>
        <a href="giohang.php">🛒 Giỏ hàng</a>
        <a href="logout.php">Đăng xuất</a>
    </header>

    <div class="noidung" style="padding:20px;">
        <h3 style="text-align:center;">CẬP NHẬT ĐƠN HÀNG</h3>
        <?= $msg ?>

        <!-- Form cập nhật số lượng / xóa -->
        <form method="post">
        <table width="600" border="1" align="center" cellpadding="5" cellspacing="0">
            <tr>
                <td colspan="2" align="center" valign="middle"><strong>CẬP NHẬT ĐƠN HÀNG</strong></td>
            </tr>
            <tr>
                <td width="200" align="left" valign="middle">Tên sản phẩm</td>
                <td width="374" align="left" valign="middle">
                    <?php
                    if ($idsp) {
                        echo $p->laygiatritheodieukien(
                            "SELECT tensp FROM sanpham WHERE idsp='$idsp' LIMIT 1"
                        );
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td align="left" valign="middle">Đơn giá</td>
                <td align="left" valign="middle">
                    <?php
                    if ($idsp) {
                        echo number_format(
                            $p->laygiatritheodieukien("SELECT gia FROM sanpham WHERE idsp='$idsp' LIMIT 1"),
                            0,',','.'
                        ) . ' USD';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td align="left" valign="middle">Số lượng</td>
                <td align="left" valign="middle">
                    <input name="txtsoluong" id="txtsoluong" type="text"
                           value="<?php
                               echo $p->laygiatritheodieukien(
                                   "SELECT soluong FROM dathang_chitiet WHERE iddh='$iddh' LIMIT 1"
                               );
                           ?>" size="5">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle">
                    <input type="submit" name="sbcapnhat" value="Cập nhật đơn hàng" class="btn">
                    <input type="submit" name="sbxoa" value="Xóa đơn hàng" class="btn btn-red">
                </td>
            </tr>
        </table>
        </form>

        <br>

        <!-- Form cập nhật địa chỉ nhận hàng -->
        <form method="post">
        <table width="600" border="1" align="center" cellpadding="5" cellspacing="0">
            <tr>
                <td colspan="2" align="center"><strong>CẬP NHẬT ĐỊA CHỈ NHẬN HÀNG</strong></td>
            </tr>
            <tr>
                <td width="200">Địa chỉ nhận hàng</td>
                <td>
                    <?php
                    $idkh           = $_SESSION['id'];
                    $diachinhanhang = $p->laygiatritheodieukien(
                        "SELECT diachinhanhang FROM khachhang WHERE idkh='$idkh' LIMIT 1"
                    );
                    ?>
                    <input type="text" name="txtdiachinhanhang"
                           value="<?= $diachinhanhang ?>" style="width:95%">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="sbcapnhatdiachinhanhang"
                           value="Cập nhật địa chỉ nhận hàng" class="btn">
                </td>
            </tr>
        </table>
        </form>

        <br>
        <p style="text-align:center;">
            <a href="giohang.php" class="btn">← Quay lại giỏ hàng</a>
        </p>
    </div>

    <footer><a href="index.php">Footer Website - Bán Điện Thoại © 2024</a></footer>
</div>
</body>
</html>
