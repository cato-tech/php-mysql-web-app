<?php
    include("classtmdt/clstmdt.php");
    $p = new csdltmdt();
    $congty = $p->xuatdulieu("SELECT * FROM congty ORDER BY tencty ASC");
?>
<html>
<head></head>
<body>
<table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="49" align="center" valign="middle"><strong>STT</strong></td>
        <td width="112" align="center" valign="middle"><strong>TÊN CÔNG TY</strong></td>
        <td width="205" align="center" valign="middle"><strong>ĐỊA CHỈ</strong></td>
        <td width="124" align="center" valign="middle"><strong>ĐIỆN THOẠI</strong></td>
    </tr>
    <?php
    for($i=0; $i<count($congty); $i++)
    {
        echo '<tr>
        <td>'.($i+1).'</td>
        <td>'.$congty[$i]['tencty'].'</td>
        <td>'.$congty[$i]['diachi'].'</td>
        <td>'.$congty[$i]['dienthoai'].'</td>
        </tr>';
    }
    ?>
</table>
</body>
</html>