<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bài 4</title>
</head>
<style type = "text/css">
	.body{
		margin: auto; padding-left: 100px; padding-top: 20px;
		}
	.a_0{font-weight: bold;}
	.a_1{font-weight: normal; font-style: italic;}	
</style>
<body>
<?php
for ($i=0;$i<31;$i++){
	echo '<span class="a_'.($i%2).'">'.$i.'</span>';
}
?>
</body>
</html>