<?php
session_start();

require('php/connection.php');
include('php/functions.php');

$user = checkSession($con);

if(!isset($user)){
    header("location: index.php");
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = mysqli_query($con, "SELECT * FROM articles where id='$id' limit 1");
    if(mysqli_num_rows($result) > 0){
        $editarticle = mysqli_fetch_assoc($result);
    }
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $article = $_POST['article'];
    $ownerID = $user['id'];
    mysqli_query($con, "INSERT INTO articles (title,article,ownerID) values ('$title','$article','$ownerID')");
    $result = mysqli_query($con, "SELECT id FROM articles order by id desc limit 1");
    $id = mysqli_fetch_assoc($result);
    header("location: article.php?id=".$id['id']);
}
$role = getRole($user);
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
    <div class="container">
        <main class="createarticle">
            <form action="createarticle.php" method="post">
                <?php
                if(isset($editarticle)){
                    $title = $editarticle['title'];
                    $article = $editarticle['article'];
                    echo $article;
                    echo "<input type=\"text\" placeholder=\"Title\" value=\"$title\" name=\"title\">
                    <textarea name=\"article\" value=\"$article\" placeholder=\"Put your entire article here, the area can be resized if prefered\"></textarea>";
                }
                else{
                ?>
                    <input type="text" placeholder="Title" name="title">
                    <textarea name="article" placeholder="Put your entire article here, the area can be resized if prefered"></textarea>
                    <input type="submit" value="Save and publish">
                <?php
                }
                ?>
                
            </form>
        </main>
    </div>
    <?php getFooter($role);?>
</body>
</html>