<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thông tin</title>
</head>

<body>
<h1>Thông tin chi tiết tác giả</h1>
<?php
$ten = $_REQUEST['ten'];
$tuoi = $_REQUEST['tuoi'];
if($ten == 'an')
{
	echo 'Nguyễn Văn An';
}
else if ($ten == 'tai')
{
	echo 'Nguyễn Anh Tài';
}
else if ($ten == 'hai')
{
	echo 'Nguyễn Thanh Hải';
}
echo '<br>';
echo 'Tuổi: '.$tuoi;
?>
</body>
</html>