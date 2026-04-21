<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Upload và xóa file</title>
</head>

<body>

<form method="post" enctype="multipart/form-data">

Chọn file:
<input type="file" name="file">

<input type="submit" name="upload" value="Upload">

</form>

<hr>

<?php

$path="";

if(isset($_POST["upload"]))
{
    $name=$_FILES["file"]["name"];
    $tmp=$_FILES["file"]["tmp_name"];

    $path="upload/".$name;

    move_uploaded_file($tmp,$path);

    echo "Upload thành công <br>";

    echo '<img src="'.$path.'" width="200"><br><br>';

    echo '<form method="post">';

    echo '<input type="hidden" name="file_path" value="'.$path.'">';

    echo '<input type="submit" name="delete" value="Xóa file">';

    echo '</form>';
}

if(isset($_POST["delete"]))
{
    $file=$_POST["file_path"];

    unlink($file);

    echo "Đã xóa file";
}

?>

</body>
</html>