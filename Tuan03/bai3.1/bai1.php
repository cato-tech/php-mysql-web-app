<?php
include("Myclass/upload.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload file</title>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" name="sbupload" value="Tải lên">

<?php
if (isset($_POST['sbupload'])) {

    $name = $_FILES["file"]["name"];
    $tmp_name = $_FILES["file"]["tmp_name"];
    $size = $_FILES["file"]["size"];

    $p = new upload();
    $p->upload($name, $tmp_name, $size);
}
?>
</form>

</body>
</html>
