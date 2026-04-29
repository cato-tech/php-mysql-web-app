<?php
session start();

if (issset($_SESSION["email"]))
{
    header("Location: trangchu.php");
    exit();
}
$email = $pass = "";
$errors = [];''

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>