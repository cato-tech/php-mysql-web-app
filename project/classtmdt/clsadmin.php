<?php
/**
 * clsadmin.php - Class xử lý đăng nhập Admin
 * Admin được lưu trong bảng `admin` (id, username, password, hoten)
 * Nếu chưa có bảng, tạo bằng SQL bên dưới:
 *
 * CREATE TABLE admin (
 *   id       INT AUTO_INCREMENT PRIMARY KEY,
 *   username VARCHAR(50)  NOT NULL UNIQUE,
 *   password VARCHAR(255) NOT NULL,
 *   hoten    VARCHAR(100) NOT NULL
 * );
 * -- Tài khoản mặc định: admin / admin123
 * INSERT INTO admin (username, password, hoten)
 * VALUES ('admin', MD5('admin123'), 'Quản trị viên');
 */

include_once("clstmdt.php");

class clsadmin extends csdltmdt {

    /**
     * Đăng nhập admin
     * @return array|false  dòng dữ liệu admin nếu đúng, false nếu sai
     */
    public function dangnhapAdmin($username, $password) {
        $username = $this->conn->real_escape_string($username);
        $password = md5($password); // Dùng MD5 đơn giản; nâng cấp lên password_hash nếu cần
        $result = $this->conn->query(
            "SELECT * FROM admin
             WHERE username='$username' AND password='$password'
             LIMIT 1"
        );
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
}
?>