<?php
include ("Myclass/dangnhap.php");
$ab = new dangnhap();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login</title>
</head>

<body>
<form id="form2" name="form2" method="post" action="">
  <table width="400" border="1" align="center" cellpadding="5">
    <tr>
      <td colspan="2"><div align="center"><strong>Đăng nhập</strong></div></td>
    </tr>
    <tr>
      <td width="123">Nhập email</td>
      <td width="245"><label for="txtten"></label>
      <input type="text" name="txtten" id="txtten" /></td>
    </tr>
    <tr>
      <td>Nhập mật khẩu</td>
      <td><label for="txtpassword"></label>
      <input type="text" name="txtpassword" id="txtpassword" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="sbdangnhap" id="sbdangnhap" value="Đăng nhập" />
      </div></td>
    </tr>
  </table>

</form>

<div align="center">
<?php
if (isset($_POST['sbdangnhap']))
{
	switch($_POST['sbdangnhap'])
	{
		case 'Đăng nhập':
		{
			$use = isset($_POST['txtten'])?$_POST['txtten']:'';
			$pass = isset($_POST['txtpassword'])?$_POST['txtpassword']:'';
			if ($use != '' && $pass != '')
			{
				if($ab->fc_dangnhap($use,$pass)==1)
				{
					echo 'Bạn đã đăng nhập thành công';
				}
				else
				{
					echo 'Đăng nhập không thành công';
				}
			}
			else
			{
				echo 'Vui lòng nhập đầy đủ thông tin';
			}
			break;
		}
	}
}

?>
</div>

</body>
</html>