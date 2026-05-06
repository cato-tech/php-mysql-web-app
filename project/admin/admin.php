<?php
/**
 * admin/admin.php  –  Quản Lý Sản Phẩm (chỉ admin)
 */
require("auth_admin.php");           // ← Kiểm tra session admin
include("../classtmdt/clstmdt.php");
$p = new csdltmdt();

$msg = '';

// XÓA sản phẩm
if (isset($_GET['xoa'])) {
    $idxoa = (int)$_GET['xoa'];
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
    <title>Admin – Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="../style/style.css">
<style>
body { background: #f5f5f5; margin: 0; }

/* ===== NAVBAR ADMIN ===== */
.admin-nav {
    background: #2c3e50;
    color: white;
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 0;
    height: 50px;
}
.admin-nav .brand {
    font-weight: bold;
    font-size: 16px;
    margin-right: 24px;
    white-space: nowrap;
}
.admin-nav a {
    color: #ecf0f1;
    text-decoration: none;
    padding: 0 16px;
    height: 50px;
    line-height: 50px;
    display: inline-block;
    font-size: 14px;
    transition: background .15s;
}
.admin-nav a:hover, .admin-nav a.nav-active { background: #34495e; }
.admin-nav .nav-right { margin-left: auto; display: flex; align-items: center; gap: 0; }
.admin-nav .nav-user { font-size: 13px; color: #bdc3c7; padding: 0 12px; }
.admin-nav a.nav-logout { color: #e74c3c; }
.admin-nav a.nav-logout:hover { background: #922b21; color: white; }

/* ===== CONTENT ===== */
.wrap { width: 980px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; }
h2, h3 { text-align: center; }
.form-box { border: 1px solid #ccc; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
.form-box label { display: block; margin-top: 8px; font-weight: bold; }
.form-box input[type=text],
.form-box textarea,
.form-box select { width: 100%; padding: 6px; margin-top: 3px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; }
.form-box button { margin-top: 12px; padding: 8px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
.form-box button:hover { background: #1e8449; }
table { width: 100%; border-collapse: collapse; }
table th, table td { border: 1px solid #ccc; padding: 7px 9px; text-align: left; vertical-align: middle; }
table th { background: #ddd; text-align: center; }
table tr:nth-child(even) { background: #f9f9f9; }
table img { width: 65px; height: 65px; object-fit: cover; border-radius: 4px; }
.btn-sua { background: #2980b9; color: white; padding: 4px 10px; border-radius: 3px; text-decoration: none; font-size: 13px; }
.btn-xoa { background: #c0392b; color: white; padding: 4px 10px; border-radius: 3px; text-decoration: none; font-size: 13px; margin-left: 4px; }
.btn-sua:hover { background: #1a6fa0; }
.btn-xoa:hover { background: #922b21; }
.msg-ok  { background:#d5f5e3; color:#1e8449; padding:8px 12px; border-radius:4px; text-align:center; }
.msg-err { background:#fdecea; color:#c0392b; padding:8px 12px; border-radius:4px; text-align:center; }
</style>
</head>
<body>

<!-- NAVBAR ADMIN -->
<nav class="admin-nav">
    <span class="brand">⚙️ ADMIN PANEL</span>
    <a href="admin.php" class="nav-active">📦 Sản phẩm</a>
    <a href="dondathang.php">🧾 Đơn hàng</a>
    <a href="../index.php">🏠 Trang chủ</a>
    <div class="nav-right">
        <span class="nav-user">👤 <?= htmlspecialchars($_SESSION['admin_ten']) ?></span>
        <a href="../admin_logout.php" class="nav-logout">🚪 Đăng xuất</a>
    </div>
</nav>

<div class="wrap">

    <h2>📦 QUẢN LÝ SẢN PHẨM</h2>
    <?= $msg ?>

    <!-- FORM THÊM -->
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

    <!-- DANH SÁCH SẢN PHẨM -->
    <h3>📋 Danh Sách Sản Phẩm
        <small style="font-weight:normal;font-size:14px;">(<?= count($dssanpham) ?> sản phẩm)</small>
    </h3>
    <table>
        <tr>
            <th>ID</th><th>Hình</th><th>Tên sản phẩm</th><th>Hãng</th>
            <th>Giá (USD)</th><th>Giảm (%)</th><th style="width:130px;">Thao tác</th>
        </tr>
        <?php if (empty($dssanpham)): ?>
        <tr>
            <td colspan="7" style="text-align:center;color:gray;padding:20px;">Chưa có sản phẩm nào</td>
        </tr>
        <?php else: ?>
            <?php foreach ($dssanpham as $sp): ?>
            <tr>
                <td align="center"><?= $sp['idsp'] ?></td>
                <td align="center">
                    <img src="../img/<?= htmlspecialchars($sp['hinh']) ?>" alt="<?= htmlspecialchars($sp['tensp']) ?>">
                </td>
                <td><?= htmlspecialchars($sp['tensp']) ?></td>
                <td><?= htmlspecialchars($sp['tencty']) ?></td>
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