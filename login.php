<?php
session_start();
    require("php/connection.php");
    if(!isset($con)){
        echo "Database connection error";
    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        $login = $_POST["login"];
        $password = $_POST["password"];
        if(isset($con) && isset($password) && isset($login)){
            $result = mysqli_query($con,"select * from users where login='$login' and password='$password' limit 1");
            if($result && mysqli_num_rows($result) > 0){
                $_SESSION["user_id"] = mysqli_fetch_assoc($result)["id"];
                echo "".$_SESSION["user_id"];
                header("location: index.php");
            }
            else{
                echo "Login or password is not correct";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="style.css">
    <title>Log in</title>
</head>
<body>
        <div class="container" id="logincontainer">
        <form action="login.php" method="post" id="login">
            <h1>Log in</h1>
            <input type="text" name="login" placeholder="Login">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" value="Log in">
            <a href="register.php"><button type="button">Register</button></a>
            <a href="reset-password.php"><button type="button">Reset password</button></a>
        </form>
        </div>
</body>
</html>