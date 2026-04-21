<?php
include ("Myclass/congthuc.php");
$ab = new tinhtoan();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tính toán</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <table width="813" border="1" cellpadding="5">
      <tr>
        <td width="226" height="50">a =
          <label for="textfield2"></label>
          <input name="txta" type="text" id="txta" value="" /></td>
        <td width="214">b =
          <label for="textfield3"></label>
          <input type="text" name="txtb" id="txtb" /></td>
        <td width="327"><div align="center">
          <input type="submit" name="nut" id="button" value="+" />
          <input type="submit" name="nut" id="-" value="-" />
          <input type="submit" name="nut" id="*" value="*" />
          <input type="submit" name="nut" id="button2" value="/" />
        </div></td>
      </tr>
      <tr>
        <td height="212" colspan="3" align="center"><?php
          if(isset($_POST['nut']))
          {
              $a = $_POST['txta'];
              $b = $_POST['txtb'];

              switch($_POST['nut'])
              {
                  case '+':
                      echo 'Kết quả: '.$ab->cong($a,$b);
                      break;

                  case '-':
                      echo 'Kết quả: '.$ab->tru($a,$b);
                      break;

                  case '*':
                      echo 'Kết quả: '.$ab->nhan($a,$b);
                      break;

                  case '/':
                      echo 'Kết quả: '.$ab->chia($a,$b);
                      break;
              }
          }
          ?></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
