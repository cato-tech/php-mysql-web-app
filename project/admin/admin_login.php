<?php
/**
 * admin/admin_login.php  –  Đăng nhập Admin
 * File này nằm TRONG thư mục admin/
 */
session_start();

// Nếu đã đăng nhập admin rồi → vào thẳng trang quản lý
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    header("Location: admin.php");   // ✅ cùng thư mục
    exit();
}

// =====================================================================
// Kết nối DB trực tiếp (không dùng clsadmin để tránh lỗi key sai)
// Chỉnh lại host/user/pass/dbname cho đúng với môi trường của bạn
// =====================================================================
$host   = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'tmdt_db';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
$conn->set_charset('utf8');

$msg = '';

if (isset($_POST['login_admin'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Truy vấn bảng taikhoan, chỉ lấy tài khoản có phanquyen = 'admin'
    $stmt = $conn->prepare(
        "SELECT iduser, hodem, ten FROM taikhoan
         WHERE username = ? AND password = ? AND phanquyen = 'admin'
         LIMIT 1"
    );
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin  = $result->fetch_assoc();
    $stmt->close();

    if ($admin) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_id']    = $admin['iduser'];               // ✅ đúng tên cột
        $_SESSION['admin_ten']   = $admin['hodem'] . ' ' . $admin['ten']; // ✅ ghép họ + tên

        // Cập nhật lần đăng nhập cuối
        $conn->query("UPDATE taikhoan SET landangnhapcuoi = NOW() WHERE iduser = " . (int)$admin['iduser']);

        header("Location: admin.php");   // ✅ cùng thư mục admin/
        exit();
    } else {
        $msg = 'Sai tên đăng nhập hoặc mật khẩu!';
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin – Đăng Nhập</title>
    <link rel="stylesheet" href="../style/style.css">
<style>
body { background: #2c3e50; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
.login-box {
    background: white;
    width: 360px;
    padding: 36px 32px 28px;
    border-radius: 10px;
    box-shadow: 0 6px 24px rgba(0,0,0,.35);
}
.login-box h2 {
    text-align: center;
    margin: 0 0 6px;
    color: #2c3e50;
    font-size: 22px;
}
.login-box .sub {
    text-align: center;
    color: #888;
    font-size: 13px;
    margin-bottom: 22px;
}
.login-box label { display: block; font-weight: bold; margin-top: 12px; font-size: 14px; }
.login-box input[type=text],
.login-box input[type=password] {
    width: 100%; padding: 9px 10px; margin-top: 4px;
    border: 1px solid #ccc; border-radius: 5px;
    box-sizing: border-box; font-size: 14px;
}
.login-box input:focus { border-color: #2980b9; outline: none; box-shadow: 0 0 0 2px #d6eaf8; }
.btn-login {
    margin-top: 20px; width: 100%; padding: 10px;
    background: #2c3e50; color: white;
    border: none; border-radius: 5px;
    font-size: 15px; cursor: pointer; font-weight: bold;
}
.btn-login:hover { background: #1a252f; }
.msg-err { background: #fdecea; color: #c0392b; padding: 8px 12px; border-radius: 4px; text-align: center; margin-bottom: 10px; font-size: 13px; }
.link-bottom { text-align: center; margin-top: 16px; font-size: 13px; }
.link-bottom a { color: #2980b9; text-decoration: none; }
.link-bottom a:hover { text-decoration: underline; }
.icon-lock { text-align: center; font-size: 40px; margin-bottom: 8px; }
</style>
</head>
<body>
<div class="login-box">
    <div class="icon-lock">🔐</div>
    <h2>ADMIN PANEL</h2>
    <p class="sub">Chỉ dành cho quản trị viên</p>

    <?php if ($msg): ?>
        <p class="msg-err"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" placeholder="Username" required autofocus
               value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">

        <label>Mật khẩu:</label>
        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button type="submit" name="login_admin" class="btn-login">🔑 Đăng nhập Admin</button>
    </form>

    <div class="link-bottom">
        <a href="../index.php">← Về trang chủ</a>
    </div>
</div>
</body>
</html>