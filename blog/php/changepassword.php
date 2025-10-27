<?php
session_start();
require("connection.php");
include("functions.php");
$user = checkSession($con);
if (!$user) {
    header("Location: ../login.php");
    die;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $passwordOld = $_POST['passwordOld'];
    $passwordNew = $_POST['passwordNew'];

    if (!empty($passwordOld) && !empty($passwordNew)) {
        if(is_numeric($passwordNew)){
            echo '<script>alert("Password cannot contain only numbers");</script>';
            die;
        }
        if($passwordNew == $passwordOld){
            echo '<script>alert("New password cannot be the same as the old one!");</script>';
            die;
        }
        $result = mysqli_query($con, "select * from users where id = '$user[id]' limit 1");

        if ($result && mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_assoc($result);
            if ($passwordOld == $userData['password']) {
                mysqli_query($con, "update users set password = '$passwordNew' where id = '$user[id]' limit 1");
                header("Location: ../profile.php");
                die;
            } else {
                echo '<script>alert("Wrong old password!");</script>';
            }
        }
    } else {
        echo '<script>alert("Please enter valid information!");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/login.css">
    <title>Change password</title>
</head>
<body>
    <form action="change-password.php" method="post">
            <h1>Change password</h1>
            <input type="password" name="passwordOld" placeholder="Old password">
            <input type="password" name="passwordNew" placeholder="New password">
            <input type="submit" value="Change password">
        </form>
</body>
</html>