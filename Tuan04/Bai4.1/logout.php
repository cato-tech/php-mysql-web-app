<?php
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
<h3>
<?php
if($_SESSION["ThongTin"])
{
   echo "Giá trị biến session là:: ".$_SESSION["ThongTin"]." <a href'logout.php'>Đăng xuất</a>";
}
else
{
    header("Location:session.php");
}
?>    
</h3>
</body>
</html>
