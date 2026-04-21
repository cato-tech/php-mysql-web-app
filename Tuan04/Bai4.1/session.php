<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session trong PHP</title>
</head>
<?php
if (isset($_POST["sbgan"]))
{
    $_SESSION["ThongTin"] = $_POST["txtthongtin"];
}
?>
<body>
<form  method="post">
<table> 
<tr>
	<td>Gán giá trị cho biến session: </td>
    <td><input type="text" name="txtthongtin"></td>
    <td><input type="submit" value="Gán" name="sbgan"></td>
</tr>
</table>
</form>
<h3>
<?php
if($_SESSION["ThongTin"])
{
    echo "Giá trị biến session là:: ".$_SESSION["ThongTin"]." <a href='logout.php'>Đăng xuất</a>";
}
else
{
    echo "Giá trị session chưa được gán";
}
?>
</h3>
</body>
</html>