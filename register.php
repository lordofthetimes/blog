<?php
session_start();
require("php/connection.php");
include("php/functions.php");
if(!isset($con)){
    echo "Database connection error";
    exit;
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

        $query = $con->prepare("SELECT * FROM users WHERE login=? LIMIT 1");
        $query->bind_param("s", $login);
        $query->execute();
        $loginExists = $query->get_result();

        if($loginExists && $loginExists->num_rows > 0){
            $con->close();
            echo '<script>alert("User with login '.$login.' already exists. Please try a different one!");</script>';
            die;
        }

        $query = $con->prepare("INSERT INTO users (login,password,role) VALUES (?,?, 'user')");
        $query->bind_param("ss", $login, $password);
        $query->execute();

        $query = $con->prepare("SELECT * FROM users WHERE login=? AND password=? LIMIT 1");
        $query->bind_param("ss", $login, $password);
        $query->execute();
        $id = $query->get_result()->fetch_assoc()['id'];


        // mysqli_query($con,"insert into user_data (userid,name,surname,pfp) values ('$id','$name','$surname','default.png')");
        $con->close();
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