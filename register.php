<?php
session_start();
require("php/connection.php");
include("php/functions.php");
if(!isset($con)){

}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['fname'];
    $surname = $_POST['surname'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    if(!empty($name) && !empty($surname) && !empty($login) && !empty($password)){
        if(is_numeric($login)){
            echo '<script>alert("Login cannot contain numbers");</script>';
            die;
        }
        if(is_numeric($name) || is_numeric($surname)){
            echo '<script>alert("Name and surname cannot contain numbers");</script>';
            die;
        }

        $loginExists = mysqli_query($con,"select * from users where login='$login' limit 1");
        if($loginExists && mysqli_num_rows($loginExists) > 0){
            echo '<script>alert("User with login '.$login.' already exists. Please try a different one!");</script>';
            mysqli_close($con);
            die;
        }

        mysqli_query($con,"insert into users (login,password,role) values ('$login','$password','user')");
        $result = mysqli_query($con,"select * from users where login='$login' and password='$password' limit 1");

        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];

        // mysqli_query($con,"insert into user_data (userid,name,surname,pfp) values ('$id','$name','$surname','default.png')");
        mysqli_close($con);
        session_start();
        header("Location: login.php");
        die;
    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="style.css">
    <script src="validate.js" defer></script>
</head>
<body>
    <div class="container" id="logincontainer">

        <form method="post" action="register.php" id="login">
            <h1>Register</h1>
            <input type="text" name="fname" placeholder="Name">
            <input type="text" name="surname" placeholder="Surname">
            <input type="text" name="login" placeholder="Login">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" value="Register">
            <a href="login.php"><button type="button">Log in instead</button></a>
        </form>
    </div>
        <!-- <form method="post" action="register.php" id="login">
            <h1>Register</h1>
            <div><label>First Name</label>        <div class="input-group"><input name="fname" id="fname" minlength="2" pattern="[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+"  type="text" placeholder="First Name"><span class="error"></span></div></div>
            <div><label>Last Name</label>         <div class="input-group"><input name="surname" id="surname" minlength="2" pattern="[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+" type="text" placeholder="Last Name"><span class="error"></span></div></div>
            <div><label>Login</label>             <div class="input-group"><input name="login" id="login" minlength="3" pattern="[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+" type="text" placeholder="Login"><span class="error"></span></div></div>
            <div><label>Password</label>          <div class="input-group"><input name="password" id="password" minlength="6" type="password" placeholder="Password"><span class="error"></span></div></div> -->

            <!-- 
                 Patterns:
                 + = jeden lub wiecej poprzedzonych znaków        
                 [] = zakres znaków
                 {} = ile razy ma wystąpić poprzedzający znak lub zakres
                 \ = znak ucieczki
                 Pattern wymaga by wartość wpisana spełniała podany wzór
                 ? = zero lub jeden poprzedający znak lub zakres
                 {a,b} = od a do b wystąpień poprzedzającego znaku lub zakresu (a lub b może być pominięte)
            -->
            <!-- <div><input type="submit" value="Register"></div>
        </form> -->
        <!-- <a href="login.php"><button>Log in instead</button></a> -->
</body>
</html>