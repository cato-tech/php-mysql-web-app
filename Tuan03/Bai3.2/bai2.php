<?php
include("myclass/clsupLoadfile.php");
$p = new myupload();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Untitled Document</title>
</head>

<body>
<form method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="file" name="file" id="file">
    <input type="submit" name="sbupload" id="sbupload" value="Tải lên">
    <div align="center">
        <?php
        if ($_POST['sbupload'] == 'Tải lên')
        {
            $name = $_FILES["file"]["name"];
            $type = $_FILES["file"]["type"];
            $tmp_name = $_FILES["file"]["tmp_name"];
            $size = $_FILES["file"]["size"];

            if ($type == "application/pdf")
            {
                if ($p->uploadfile($tmp_name, $name, "data") == 1)
                {
                    echo "Upload thành công";
                }
                else
                {
                    echo "Lỗi";
                }
            }
            else
            {
                echo "Chỉ cho upload file pdf";
            }
        }
        ?>
    </div>
</form>
</body>
</html>
