<?php
/**
 * Class csdltmdt - Xử lý kết nối và thao tác CSDL
 */
class csdltmdt
{
    // Kết nối database
    private function connect()
    {
        $con = new mysqli("localhost", "root", "", "tmdt_db");
        if ($con->connect_error) {
            die("Kết nối thất bại: " . $con->connect_error);
        }
        $con->set_charset("utf8");
        return $con;
    }

    // Trả về mảng nhiều dòng
    public function xuatdulieu($sql)
    {
        $arr  = array();
        $link = $this->connect();
        $result = $link->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
        $link->close();
        return $arr;
    }

    // Trả về 1 giá trị đơn (ô đầu tiên của dòng đầu tiên)
    public function laygiatritheodieukien($sql)
    {
        $link   = $this->connect();
        $result = $link->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $link->close();
            return array_values($row)[0];
        }
        $link->close();
        return null;
    }

    // Thực thi INSERT / UPDATE / DELETE, trả về insert_id hoặc 1/0
    public function thucthisql($sql)
    {
        $link = $this->connect();
        if ($link->query($sql)) {
            $id = $link->insert_id;
            $link->close();
            return $id ? $id : 1;
        }
        $link->close();
        return 0;
    }

    // Tạo dropdown công ty
    public function combobox($sql)
    {
        $link   = $this->connect();
        $result = $link->query($sql);
        if ($result && $result->num_rows > 0) {
            echo '<select name="congty" id="congty">';
            echo '<option value="0">-- Chọn công ty --</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['idcty'] . '">' . $row['tencty'] . '</option>';
            }
            echo '</select>';
        }
        $link->close();
    }

    // Thêm sản phẩm kèm upload hình
    public function themsanpham($idcty, $tensp, $gia, $giamgia, $mota, $file)
    {
        $conn = $this->connect();
        $hinh = time() . "_" . basename($file['name']);
        move_uploaded_file($file['tmp_name'], "../img/" . $hinh);
        $tensp  = $conn->real_escape_string($tensp);
        $mota   = $conn->real_escape_string($mota);
        $sql = "INSERT INTO sanpham (tensp, gia, mota, hinh, giamgia, idcty)
                VALUES ('$tensp','$gia','$mota','$hinh','$giamgia','$idcty')";
        $ok = $conn->query($sql);
        $conn->close();
        return $ok;
    }
}