<?php
// 7.3 - Xem danh sách đặt hàng phía admin
include("../classtmdt/clstmdt.php");
$p = new csdltmdt();

$msg = '';

// Xác nhận đơn hàng (trangthai 0 → 1)
if (isset($_GET['xacnhan'])) {
    $iddh = $_GET['xacnhan'];
    $ok   = $p->thucthisql("UPDATE dathang SET trangthai='1' WHERE iddh='$iddh'");
    $msg  = $ok ? '<p class="msg-ok">✅ Đã xác nhận đơn hàng #' . $iddh . '</p>'
                : '<p class="msg-err">❌ Xác nhận thất bại!</p>';
}

// Hủy đơn hàng (xóa)
if (isset($_GET['huy'])) {
    $iddh = $_GET['huy'];
    $p->thucthisql("DELETE FROM dathang_chitiet WHERE iddh='$iddh'");
    $ok   = $p->thucthisql("DELETE FROM dathang WHERE iddh='$iddh'");
    $msg  = $ok ? '<p class="msg-ok">✅ Đã hủy đơn hàng #' . $iddh . '</p>'
                : '<p class="msg-err">❌ Hủy thất bại!</p>';
}

// Lọc theo trạng thái
$filter = isset($_GET['trangthai']) ? $_GET['trangthai'] : 'all';
$where  = '';
if ($filter === '0') $where = "WHERE dh.trangthai = '0'";
if ($filter === '1') $where = "WHERE dh.trangthai = '1'";

// Lấy danh sách đơn hàng kèm thông tin khách
$dondathang = $p->xuatdulieu(
    "SELECT dh.iddh, dh.ngaydathang, dh.trangthai,
            kh.idkh, kh.hodem, kh.ten, kh.email, kh.dienthoai, kh.diachinhanhang,
            COUNT(ct.idsp) AS so_sp,
            SUM(ct.soluong * ct.dongia - ct.soluong * ct.giamgia) AS tongtien
     FROM dathang dh
     LEFT JOIN khachhang kh ON dh.idkh = kh.idkh
     LEFT JOIN dathang_chitiet ct ON dh.iddh = ct.iddh
     $where
     GROUP BY dh.iddh
     ORDER BY dh.iddh DESC"
);

// Thống kê
$tatca    = $p->laygiatritheodieukien("SELECT COUNT(*) FROM dathang");
$choduyet = $p->laygiatritheodieukien("SELECT COUNT(*) FROM dathang WHERE trangthai='0'");
$daxacnhan= $p->laygiatritheodieukien("SELECT COUNT(*) FROM dathang WHERE trangthai='1'");
$doanhthu = $p->laygiatritheodieukien(
    "SELECT SUM(ct.soluong * ct.dongia - ct.soluong * ct.giamgia)
     FROM dathang dh JOIN dathang_chitiet ct ON dh.iddh=ct.iddh
     WHERE dh.trangthai='1'"
);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="../style/style.css">
<style>
body { background: #f5f5f5; }
.wrap { width: 980px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; }
h2 { text-align: center; }

/* Thống kê */
.thongke {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}
.tk-box {
    flex: 1;
    text-align: center;
    padding: 14px;
    border-radius: 8px;
    color: white;
    font-size: 15px;
}
.tk-box strong { display: block; font-size: 26px; }
.tk-blue   { background: #2980b9; }
.tk-orange { background: #e67e22; }
.tk-green  { background: #27ae60; }
.tk-purple { background: #8e44ad; }

/* Bộ lọc */
.filter { margin-bottom: 14px; }
.filter a {
    display: inline-block;
    padding: 5px 14px;
    margin-right: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
    text-decoration: none;
    color: black;
    font-size: 13px;
}
.filter a.active-filter { background: #555; color: white; border-color: #555; }

/* Bảng */
table { width: 100%; border-collapse: collapse; font-size: 13px; }
table th, table td { border: 1px solid #ccc; padding: 7px 9px; vertical-align: middle; }
table th { background: #ddd; text-align: center; }
table tr:nth-child(even) { background: #f9f9f9; }
.badge { padding: 3px 9px; border-radius: 12px; font-size: 12px; font-weight: bold; color: white; }
.badge-cho  { background: #e67e22; }
.badge-xong { background: #27ae60; }
.btn-xn  { background: #27ae60; color: white; padding: 4px 9px; border-radius: 3px; text-decoration: none; font-size: 12px; }
.btn-huy { background: #c0392b; color: white; padding: 4px 9px; border-radius: 3px; text-decoration: none; font-size: 12px; margin-left: 3px; }
.btn-xn:hover  { background: #1e8449; }
.btn-huy:hover { background: #922b21; }

/* Chi tiết đơn */
.chitiet-wrap { display: none; background: #f9f9f9; padding: 10px; border-top: 1px solid #ccc; }
</style>
</head>
<body>
<div class="wrap">

    <h2>📦 QUẢN LÝ ĐƠN HÀNG</h2>
    <p style="text-align:center;">
        <a href="admin.php" class="btn">← Quản lý sản phẩm</a>
        <a href="../index.php" class="btn">🏠 Trang chủ</a>
    </p>

    <?= $msg ?>

    <!-- THỐNG KÊ -->
    <div class="thongke">
        <div class="tk-box tk-blue">
            <strong><?= $tatca ?? 0 ?></strong> Tổng đơn hàng
        </div>
        <div class="tk-box tk-orange">
            <strong><?= $choduyet ?? 0 ?></strong> Chờ duyệt
        </div>
        <div class="tk-box tk-green">
            <strong><?= $daxacnhan ?? 0 ?></strong> Đã xác nhận
        </div>
        <div class="tk-box tk-purple">
            <strong><?= number_format($doanhthu ?? 0, 0, ',', '.') ?></strong> Doanh thu (USD)
        </div>
    </div>

    <!-- BỘ LỌC -->
    <div class="filter">
        <strong>Lọc:</strong>
        <a href="dondathang.php" <?= $filter=='all' ? 'class="active-filter"' : '' ?>>Tất cả</a>
        <a href="dondathang.php?trangthai=0" <?= $filter=='0' ? 'class="active-filter"' : '' ?>>⏳ Chờ duyệt</a>
        <a href="dondathang.php?trangthai=1" <?= $filter=='1' ? 'class="active-filter"' : '' ?>>✅ Đã xác nhận</a>
    </div>

    <!-- BẢNG ĐƠN HÀNG -->
    <?php if (empty($dondathang)): ?>
        <p style="text-align:center;color:gray;padding:20px;">Không có đơn hàng nào.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Địa chỉ nhận</th>
            <th>Số SP</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($dondathang as $don): ?>
        <tr>
            <td align="center"><strong>#<?= $don['iddh'] ?></strong></td>
            <td><?= $don['hodem'] . ' ' . $don['ten'] ?></td>
            <td><?= $don['email'] ?></td>
            <td><?= $don['dienthoai'] ?></td>
            <td><?= $don['diachinhanhang'] ?: '<i style="color:gray;">Chưa cập nhật</i>' ?></td>
            <td align="center"><?= $don['so_sp'] ?></td>
            <td align="right"><strong><?= number_format($don['tongtien'],0,',','.') ?> USD</strong></td>
            <td><?= $don['ngaydathang'] ?></td>
            <td align="center">
                <?php if ($don['trangthai'] == 0): ?>
                    <span class="badge badge-cho">⏳ Chờ duyệt</span>
                <?php else: ?>
                    <span class="badge badge-xong">✅ Đã xác nhận</span>
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if ($don['trangthai'] == 0): ?>
                    <a href="dondathang.php?xacnhan=<?= $don['iddh'] ?>"
                       class="btn-xn"
                       onclick="return confirm('Xác nhận đơn hàng #<?= $don['iddh'] ?>?')">
                       ✅ Xác nhận
                    </a>
                <?php endif; ?>
                <a href="dondathang.php?huy=<?= $don['iddh'] ?>"
                   class="btn-huy"
                   onclick="return confirm('Hủy đơn hàng #<?= $don['iddh'] ?>?')">
                   🗑️ Hủy
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

</div>
</body>
</html>
