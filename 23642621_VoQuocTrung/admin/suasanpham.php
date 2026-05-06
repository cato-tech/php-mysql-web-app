<?php
// Admin - Sửa sản phẩm
include("../classtmdt/clstmdt.php");
$p = new csdltmdt();

$idsp = isset($_GET['idsp']) ? $_GET['idsp'] : 0;
$msg  = '';

// Lấy thông tin sản phẩm hiện tại
$arr = $p->xuatdulieu("SELECT * FROM sanpham WHERE idsp='$idsp' LIMIT 1");
if (empty($arr)) {
    echo '<p style="text-align:center;color:red;">Sản phẩm không tồn tại!</p>';
    exit();
}
$sp = $arr[0]; // dòng dữ liệu hiện tại

// XỬ LÝ LƯU KHI BẤM NÚT
if (isset($_POST['btnsua'])) {
    $congty   = $_POST['congty'];
    $tensp    = $_POST['txtsp'];
    $gia      = $_POST['txtgia'];
    $giamgia  = $_POST['txtgiamgia'];
    $mota     = $_POST['txtmota'];

    // Kiểm tra có upload hình mới không
    if (!empty($_FILES['img']['name'])) {
        // Xóa hình cũ
        $hinhcu = "../img/" . $sp['hinh'];
        if (file_exists($hinhcu)) unlink($hinhcu);

        // Upload hình mới
        $hinhmoi = time() . "_" . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], "../img/" . $hinhmoi);
    } else {
        // Giữ hình cũ
        $hinhmoi = $sp['hinh'];
    }

    $ok = $p->thucthisql(
        "UPDATE sanpham SET
            tensp  = '$tensp',
            gia    = '$gia',
            giamgia= '$giamgia',
            mota   = '$mota',
            hinh   = '$hinhmoi',
            idcty  = '$congty'
         WHERE idsp = '$idsp'"
    );

    if ($ok) {
        $msg = '<p class="msg-ok">✅ Cập nhật sản phẩm thành công!</p>';
        // Reload lại dữ liệu mới
        $arr = $p->xuatdulieu("SELECT * FROM sanpham WHERE idsp='$idsp' LIMIT 1");
        $sp  = $arr[0];
    } else {
        $msg = '<p class="msg-err">❌ Cập nhật thất bại!</p>';
    }
}

// Lấy danh sách công ty cho dropdown
$congtylist = $p->xuatdulieu("SELECT * FROM congty ORDER BY tencty ASC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Sản Phẩm</title>
    <link rel="stylesheet" href="../style/style.css">
<style>
body { background: #f5f5f5; }
.wrap { width: 560px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; }
h2 { text-align: center; }
label { display: block; margin-top: 10px; font-weight: bold; }
input[type=text], textarea, select {
    width: 100%; padding: 7px; margin-top: 4px;
    border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
}
.hinh-preview { text-align: center; margin: 10px 0; }
.hinh-preview img { width: 140px; height: 140px; object-fit: cover; border: 2px solid #ccc; border-radius: 6px; }
.btn-luu { margin-top: 14px; width: 100%; padding: 9px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
.btn-luu:hover { background: #1e8449; }
.link-back { text-align: center; margin-top: 10px; }
</style>
</head>
<body>
<div class="wrap">

    <h2>✏️ SỬA SẢN PHẨM</h2>
    <?= $msg ?>

    <!-- Xem trước hình hiện tại -->
    <div class="hinh-preview">
        <p style="margin:0;font-size:13px;color:gray;">Hình hiện tại:</p>
        <img src="../img/<?= $sp['hinh'] ?>" id="preview" alt="<?= $sp['tensp'] ?>">
    </div>

    <form method="post" enctype="multipart/form-data">

        <label>Công ty:</label>
        <select name="congty">
            <?php foreach ($congtylist as $ct): ?>
            <option value="<?= $ct['idcty'] ?>"
                <?= $ct['idcty'] == $sp['idcty'] ? 'selected' : '' ?>>
                <?= $ct['tencty'] ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Tên sản phẩm:</label>
        <input type="text" name="txtsp" value="<?= $sp['tensp'] ?>" required>

        <label>Giá (USD):</label>
        <input type="text" name="txtgia" value="<?= $sp['gia'] ?>" required>

        <label>Giảm giá (%):</label>
        <input type="text" name="txtgiamgia" value="<?= $sp['giamgia'] ?>">

        <label>Mô tả:</label>
        <textarea name="txtmota" rows="4"><?= $sp['mota'] ?></textarea>

        <label>Hình ảnh mới <small style="font-weight:normal;">(để trống = giữ hình cũ)</small>:</label>
        <input type="file" name="img" accept="image/*"
               onchange="document.getElementById('preview').src=URL.createObjectURL(this.files[0])">

        <button type="submit" name="btnsua" class="btn-luu">💾 Lưu thay đổi</button>
    </form>

    <div class="link-back">
        <a href="admin.php" class="btn">← Quay lại danh sách</a>
    </div>

</div>
</body>
</html>
