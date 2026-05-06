<?php
// 7.3 - Lịch sử mua hàng phía người dùng
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include("classtmdt/clskhachhang.php");
$p = new khachhang();

$idkh   = $_SESSION['id'];
$congty = $p->XemDSCongTy();

// Lấy toàn bộ lịch sử (kể cả đã xác nhận trangthai=1)
$lichsu = $p->xuatdulieu(
    "SELECT dh.iddh, dh.ngaydathang, dh.trangthai,
            ct.idsp, ct.soluong, ct.dongia, ct.giamgia
     FROM dathang dh
     JOIN dathang_chitiet ct ON dh.iddh = ct.iddh
     WHERE dh.idkh = '$idkh'
     ORDER BY dh.iddh DESC"
);

// Tính tổng tiền theo từng đơn
$dondathang = [];
foreach ($lichsu as $row) {
    $iddh = $row['iddh'];
    if (!isset($dondathang[$iddh])) {
        $dondathang[$iddh] = [
            'iddh'        => $iddh,
            'ngaydathang' => $row['ngaydathang'],
            'trangthai'   => $row['trangthai'],
            'sanpham'     => [],
            'tongtien'    => 0
        ];
    }
    $tensp = $p->laygiatritheodieukien(
        "SELECT tensp FROM sanpham WHERE idsp='" . $row['idsp'] . "' LIMIT 1"
    );
    $thanhtien = ($row['soluong'] * $row['dongia']) - ($row['soluong'] * $row['giamgia']);
    $dondathang[$iddh]['sanpham'][] = [
        'tensp'     => $tensp,
        'soluong'   => $row['soluong'],
        'dongia'    => $row['dongia'],
        'giamgia'   => $row['giamgia'],
        'thanhtien' => $thanhtien
    ];
    $dondathang[$iddh]['tongtien'] += $thanhtien;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Mua Hàng</title>
    <link rel="stylesheet" href="style/style.css">
<style>
.don-hang {
    border: 1px solid #ccc;
    border-radius: 6px;
    margin: 15px 0;
    overflow: hidden;
}
.don-hang .don-header {
    background: #eee;
    padding: 8px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}
.don-hang .don-header strong { font-size: 14px; }
.badge {
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}
.badge-cho  { background: #e67e22; }
.badge-xong { background: #27ae60; }
.don-hang table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.don-hang table th, .don-hang table td {
    border: 1px solid #ddd;
    padding: 6px 10px;
}
.don-hang table th { background: #f5f5f5; text-align: center; }
.don-hang .don-footer {
    background: #f9f9f9;
    padding: 8px 12px;
    text-align: right;
    font-weight: bold;
    border-top: 1px solid #ddd;
}
.tong-thong-ke {
    background: #eaf4fb;
    border: 1px solid #aed6f1;
    border-radius: 6px;
    padding: 12px 16px;
    margin-bottom: 16px;
    font-size: 14px;
}
</style>
</head>
<body>
<div class="container">

    <header>
        <h1>WEBSITE BÁN ĐIỆN THOẠI</h1>
        <a href="index.php">🏠 Trang chủ</a>
        <a href="giohang.php">🛒 Giỏ hàng</a>
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
            <h3>📋 LỊCH SỬ MUA HÀNG</h3>

            <?php if (empty($dondathang)): ?>
                <p style="text-align:center;color:gray;">
                    Bạn chưa có đơn hàng nào. <a href="index.php">Mua sắm ngay</a>
                </p>
            <?php else: ?>

                <!-- Thống kê tổng quan -->
                <?php
                $tongdon  = count($dondathang);
                $daxacnhan = array_filter($dondathang, fn($d) => $d['trangthai'] == 1);
                $choduyet  = array_filter($dondathang, fn($d) => $d['trangthai'] == 0);
                $tongchitieu = array_sum(array_column($dondathang, 'tongtien'));
                ?>
                <div class="tong-thong-ke">
                    📦 Tổng đơn hàng: <strong><?= $tongdon ?></strong> &nbsp;|&nbsp;
                    ✅ Đã xác nhận: <strong><?= count($daxacnhan) ?></strong> &nbsp;|&nbsp;
                    ⏳ Chờ duyệt: <strong><?= count($choduyet) ?></strong> &nbsp;|&nbsp;
                    💰 Tổng chi tiêu: <strong><?= number_format($tongchitieu,0,',','.') ?> USD</strong>
                </div>

                <!-- Danh sách từng đơn -->
                <?php foreach ($dondathang as $don): ?>
                <div class="don-hang">
                    <div class="don-header">
                        <div>
                            <strong>Đơn #<?= $don['iddh'] ?></strong>
                            &nbsp;|&nbsp; 🗓 <?= $don['ngaydathang'] ?>
                        </div>
                        <div>
                            <?php if ($don['trangthai'] == 0): ?>
                                <span class="badge badge-cho">⏳ Chờ duyệt</span>
                            <?php else: ?>
                                <span class="badge badge-xong">✅ Đã xác nhận</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <table>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Giảm giá</th>
                            <th>Thành tiền</th>
                        </tr>
                        <?php foreach ($don['sanpham'] as $sp): ?>
                        <tr>
                            <td><?= $sp['tensp'] ?></td>
                            <td align="center"><?= $sp['soluong'] ?></td>
                            <td align="right"><?= number_format($sp['dongia'],0,',','.') ?> USD</td>
                            <td align="center"><?= $sp['giamgia'] ?>%</td>
                            <td align="right"><?= number_format($sp['thanhtien'],0,',','.') ?> USD</td>
                        </tr>
                        <?php endforeach; ?>
                    </table>

                    <div class="don-footer">
                        Tổng tiền đơn: <?= number_format($don['tongtien'],0,',','.') ?> USD
                    </div>
                </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>

    <footer><a href="index.php">Footer Website - Bán Điện Thoại © 2024</a></footer>
</div>
</body>
</html>
