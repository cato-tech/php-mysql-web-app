<?php
/**
 * Class clslogin - Xử lý đăng nhập đơn giản
 */
class clslogin
{
    public function login($user, $pass)
    {
        // Tài khoản cứng (có thể đổi sang DB sau)
        if ($user == 'usertmdt' && $pass == 'passtmdt') {
            $_SESSION['login']    = true;
            $_SESSION['username'] = $user;
            $_SESSION['id']       = 1; // idkh mặc định
            return 1;
        }
        return 0;
    }

    // Kiểm tra đã đăng nhập chưa, nếu chưa → redirect
    public function checkLogin()
    {
        if (!isset($_SESSION['login']) || !$_SESSION['login']) {
            header("Location: login.php");
            exit();
        }
    }
}