<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("php/connection.php");
require("php/functions.php");

$user = checkSession($con);

$articles = $con->query("SELECT * FROM articles ORDER BY id DESC LIMIT 12")->fetch_all(MYSQLI_ASSOC);

$con->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Blog</title>
</head>
<body>
    <?php
    getNav(getRole($user));
    ?>
    <div class="container">
        <main class="index">
            <?php
            foreach($articles as $article){
                echo '<div>
                <h3>'.substr($article['title'],0,30).'</h3>
                <p>'.substr($article['article'],0,100).'...</p>
                <a href="article.php?id='.$article['id'].'">Read more →</a>
             </div>';
            }
            ?>
        </main>
    </div>
    <?php
    getFooter();
    ?>
</body>
</html>