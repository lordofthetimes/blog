<?php
session_start();
require("php/connection.php");
if(!isset($con)){
        echo "Database connection error";
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $login = $_POST["login"];
    $password = $_POST["password"];
    if(empty($login) || empty($password)){
        echo "Please fill in both fields";
        exit;
    }
    if(isset($con) && isset($password) && isset($login)){

        $query = $con->prepare("SELECT * FROM users WHERE login=? AND password=? LIMIT 1");
        $query->bind_param("ss", $login, $password);
        $query->execute();
        $result = $query->get_result();

        if($result && $result->num_rows > 0){
            $_SESSION["user_id"] = $result->fetch_assoc()["id"];
            $con->close();
            header("location: index.php");
            exit;
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