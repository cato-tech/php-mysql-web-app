<?php
// Admin - Thêm / Xem / Xóa sản phẩm
include("../classtmdt/clstmdt.php");
$p = new csdltmdt();

$msg = '';

// XÓA sản phẩm
if (isset($_GET['xoa'])) {
    $idxoa = $_GET['xoa'];
    $hinh  = $p->laygiatritheodieukien("SELECT hinh FROM sanpham WHERE idsp='$idxoa' LIMIT 1");
    $ok    = $p->thucthisql("DELETE FROM sanpham WHERE idsp='$idxoa'");
    if ($ok) {
        $duongdan = "../img/" . $hinh;
        if (file_exists($duongdan)) unlink($duongdan);
        $msg = '<p class="msg-ok">✅ Xóa sản phẩm thành công!</p>';
    } else {
        $msg = '<p class="msg-err">❌ Xóa thất bại! (Có thể sản phẩm đang có đơn hàng)</p>';
    }
}

// THÊM sản phẩm
if (isset($_POST['btn'])) {
    $kq = $p->themsanpham(
        $_POST['congty'],
        $_POST['txtsp'],
        $_POST['txtgia'],
        $_POST['txtgiamgia'],
        $_POST['txtmota'],
        $_FILES['img']
    );
    $msg = $kq ? '<p class="msg-ok">✅ Thêm sản phẩm thành công!</p>'
               : '<p class="msg-err">❌ Thêm thất bại!</p>';
}

// Danh sách sản phẩm kèm tên công ty
$dssanpham = $p->xuatdulieu(
    "SELECT sp.*, ct.tencty FROM sanpham sp
     LEFT JOIN congty ct ON sp.idcty = ct.idcty
     ORDER BY sp.idsp DESC"
);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="../style/style.css">
<style>
body { background: #f5f5f5; }
.wrap { width: 980px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; }
h2, h3 { text-align: center; }
/* Form thêm */
.form-box { border: 1px solid #ccc; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
.form-box label { display: block; margin-top: 8px; font-weight: bold; }
.form-box input[type=text],
.form-box textarea,
.form-box select { width: 100%; padding: 6px; margin-top: 3px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; }
.form-box button { margin-top: 12px; padding: 8px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
.form-box button:hover { background: #1e8449; }
/* Bảng */
table { width: 100%; border-collapse: collapse; }
table th, table td { border: 1px solid #ccc; padding: 7px 9px; text-align: left; vertical-align: middle; }
table th { background: #ddd; text-align: center; }
table tr:nth-child(even) { background: #f9f9f9; }
table img { width: 65px; height: 65px; object-fit: cover; border-radius: 4px; }
.btn-sua { background: #2980b9; color: white; padding: 4px 10px; border-radius: 3px; text-decoration: none; font-size: 13px; }
.btn-xoa { background: #c0392b; color: white; padding: 4px 10px; border-radius: 3px; text-decoration: none; font-size: 13px; margin-left: 4px; }
.btn-sua:hover { background: #1a6fa0; }
.btn-xoa:hover { background: #922b21; }
</style>
</head>
<body>
<div class="wrap">

    <h2>⚙️ QUẢN LÝ SẢN PHẨM</h2>
    <p style="text-align:center;"><a href="../index.php" class="btn">← Về trang chủ</a></p>

    <?= $msg ?>

    <!-- ===== FORM THÊM ===== -->
    <div class="form-box">
        <h3 style="margin-top:0;">➕ Thêm Sản Phẩm Mới</h3>
        <form method="post" enctype="multipart/form-data">
            <label>Công ty:</label>
            <?php $p->combobox("SELECT * FROM congty ORDER BY tencty ASC"); ?>

            <label>Tên sản phẩm:</label>
            <input type="text" name="txtsp" placeholder="Tên sản phẩm" required>

            <label>Giá (USD):</label>
            <input type="text" name="txtgia" placeholder="Ví dụ: 199" required>

            <label>Giảm giá (%):</label>
            <input type="text" name="txtgiamgia" value="0">

            <label>Mô tả:</label>
            <textarea name="txtmota" rows="3" placeholder="Mô tả sản phẩm"></textarea>

            <label>Hình ảnh:</label>
            <input type="file" name="img" accept="image/*">

            <button type="submit" name="btn">➕ Thêm sản phẩm</button>
        </form>
    </div>

    <!-- ===== DANH SÁCH SẢN PHẨM ===== -->
    <h3>📋 Danh Sách Sản Phẩm
        <small style="font-weight:normal;font-size:14px;">(<?= count($dssanpham) ?> sản phẩm)</small>
    </h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Hình</th>
            <th>Tên sản phẩm</th>
            <th>Hãng</th>
            <th>Giá (USD)</th>
            <th>Giảm (%)</th>
            <th style="width:130px;">Thao tác</th>
        </tr>
        <?php if (empty($dssanpham)): ?>
        <tr>
            <td colspan="7" style="text-align:center;color:gray;padding:20px;">
                Chưa có sản phẩm nào
            </td>
        </tr>
        <?php else: ?>
            <?php foreach ($dssanpham as $sp): ?>
            <tr>
                <td align="center"><?= $sp['idsp'] ?></td>
                <td align="center">
                    <img src="../img/<?= $sp['hinh'] ?>" alt="<?= $sp['tensp'] ?>">
                </td>
                <td><?= $sp['tensp'] ?></td>
                <td><?= $sp['tencty'] ?></td>
                <td><?= number_format($sp['gia'], 0, ',', '.') ?></td>
                <td align="center"><?= $sp['giamgia'] ?>%</td>
                <td align="center">
                    <a href="suasanpham.php?idsp=<?= $sp['idsp'] ?>" class="btn-sua">✏️ Sửa</a>
                    <a href="admin.php?xoa=<?= $sp['idsp'] ?>"
                       class="btn-xoa"
                       onclick="return confirm('Xóa sản phẩm \'<?= addslashes($sp['tensp']) ?>\'?')">
                       🗑️ Xóa
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

</div>
</body>
</html>