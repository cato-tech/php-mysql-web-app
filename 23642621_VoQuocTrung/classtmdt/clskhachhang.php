<?php
include_once("clstmdt.php");

/**
 * Class khachhang - Các chức năng phía khách hàng
 * Kế thừa csdltmdt
 */
class khachhang extends csdltmdt
{
    // 6.1 - Xem danh sách sản phẩm (có thể lọc theo công ty)
    public function XemDSSanPham($id_congty = '')
    {
        if ($id_congty != '') {
            return $this->xuatdulieu(
                "SELECT * FROM sanpham WHERE idcty='$id_congty' ORDER BY gia ASC"
            );
        } else {
            return $this->xuatdulieu("SELECT * FROM sanpham ORDER BY gia ASC");
        }
    }

    // 6.1 - Xem danh sách công ty cho menu
    public function XemDSCongTy()
    {
        return $this->xuatdulieu("SELECT * FROM congty ORDER BY tencty ASC");
    }

    // 6.2 - Xem chi tiết 1 sản phẩm
    public function chitietsanpham($idsp)
    {
        return $this->xuatdulieu(
            "SELECT * FROM sanpham WHERE idsp='$idsp' LIMIT 1"
        );
    }

    // 6.4 - Xem giỏ hàng của khách (trangthai=0 là chưa xác nhận)
    public function giohang($idkh)
    {
        return $this->xuatdulieu(
            "SELECT dh.iddh, dh.ngaydathang, dh.trangthai,
                    ct.idsp, ct.soluong, ct.dongia, ct.giamgia
             FROM dathang dh, dathang_chitiet ct
             WHERE dh.iddh = ct.iddh
               AND dh.trangthai = '0'
               AND dh.idkh = '$idkh'"
        );
    }

    // Đăng nhập khách hàng
    public function dangnhap($email, $pass)
    {
        $arr = $this->xuatdulieu(
            "SELECT * FROM khachhang
             WHERE email='$email' AND password='$pass' LIMIT 1"
        );
        return count($arr) > 0 ? $arr[0] : false;
    }

    // Đăng ký khách hàng mới
    public function dangky($email, $pass, $hodem, $ten, $diachi, $dienthoai)
    {
        return $this->thucthisql(
            "INSERT INTO khachhang (email, password, hodem, ten, diachi, dienthoai)
             VALUES ('$email','$pass','$hodem','$ten','$diachi','$dienthoai')"
        );
    }
}
