<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<table border = "1" style="margin:auto; text-align:center;">
	<tr>
    	<th>i</th>
        <th>Kết quả</th>
    </tr>
<?php
for($i=0; $i<=10; $i++){
	$kq = pow($i,$i+1);
	echo "<tr>";
	echo "<td>$i</td>";
	echo "<td>".number_format($kq)."</td>";
	echo "</tr>";
}
?>
</table>
<body> 
</body>
</html>