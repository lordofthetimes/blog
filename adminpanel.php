<?php
session_start();

require('php/connection.php');
include('php/functions.php');

$user = checkSession($con);

if(!isset($user)){
    header("location: index.php");
}
$role = getRole($user);
if(!isAdmin($role)){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Create new article</title>
</head>
<body>
    <?php getNav($role);?>
    <?php getFooter($role);?>
</body>
</html>