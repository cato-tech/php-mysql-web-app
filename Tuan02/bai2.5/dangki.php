<?php
$email="";
$pass="";
$repass="";
$hoten="";
$quequan="";
$dienthoai="";
$gioitinh="";
$sothich="";

if(isset($_POST["dangky"]))
{
    $email=$_POST["email"];
    $pass=$_POST["pass"];
    $repass=$_POST["repass"];
    $hoten=$_POST["hoten"];
    $quequan=$_POST["quequan"];
    $dienthoai=$_POST["dienthoai"];
    $gioitinh=$_POST["gioitinh"];

    if(isset($_POST["sothich"]))
    {
        $sothich=implode(", ",$_POST["sothich"]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Đăng ký</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

<header>
BANNER WEBSITE
</header>

<div class="main">

<nav>

<b>Menu</b><br><br>

Trang chủ<br>
Đăng ký<br>
Đăng nhập

</nav>

<div class="content">

<h3>THÔNG TIN ĐĂNG KÝ</h3>

<form method="post">

<b>Thông tin tài khoản</b><br><br>

Email<br>
<input type="email" name="email"><br><br>

Password<br>
<input type="password" name="pass"><br><br>

Nhập lại password<br>
<input type="password" name="repass"><br><br>

<b>Thông tin cá nhân</b><br><br>

Họ tên<br>
<input type="text" name="hoten"><br><br>

Quê quán<br>
<select name="quequan">
<option>Chọn Tỉnh/Thành phố</option>
<option>TP Hồ Chí Minh</option>
<option>Hà Nội</option>
<option>Đà Nẵng</option>
</select>

<br><br>

Điện thoại<br>
<input type="text" name="dienthoai">

<br><br>

Giới tính<br>

<input type="radio" name="gioitinh" value="Nam"> Nam
<input type="radio" name="gioitinh" value="Nữ"> Nữ

<br><br>

Sở thích<br>

<input type="checkbox" name="sothich[]" value="Màu xanh">Màu xanh
<input type="checkbox" name="sothich[]" value="Màu đỏ">Màu đỏ
<input type="checkbox" name="sothich[]" value="Đồng quê">Đồng quê
<input type="checkbox" name="sothich[]" value="Cao nguyên">Cao nguyên

<br><br>

<button type="submit" name="dangky">Đăng ký</button>
<button type="reset">Làm lại</button>

</form>

<hr>

<?php

if(isset($_POST["dangky"]))
{
    echo "<h3>Thông tin đã đăng ký</h3>";

    echo "Email: ".$email."<br>";
    echo "Họ tên: ".$hoten."<br>";
    echo "Quê quán: ".$quequan."<br>";
    echo "Điện thoại: ".$dienthoai."<br>";
    echo "Giới tính: ".$gioitinh."<br>";
    echo "Sở thích: ".$sothich."<br>";
}

?>

</div>

</div>

<footer>
Footer website
</footer>

</div>

</body>
</html>