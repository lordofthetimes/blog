<?php
session_start();

require('php/connection.php');
include('php/functions.php');

$user = checkSession($con);

if(!isset($user)){
    header("location: index.php");
    exit;
}

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $query = $con->prepare("SELECT * FROM articles WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    if($result->num_rows > 0){

        $editarticle = $result->fetch_assoc();
        $con->close();
        if(!($editarticle['ownerID'] == $user['id'] || isAdmin(getRole($user)))){
            header("location: index.php");
            exit;
        }
    }
}
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    $title = $_POST['title'];
    $article = $_POST['article'];
    $ownerID = $user['id'];

    if( isset($_POST['id']) && ($ownerID == $user['id'] || isAdmin(getRole($user))) ){
        $id = $_POST['id'];

        $query = $con->prepare("UPDATE articles SET title = ?, article = ? WHERE id = ?");
        $query->bind_param("ssi", $title, $article, $id);
        $query->execute();

        header("location: article.php?id=".$id);
        exit;
    }

    $query = $con->prepare("INSERT INTO articles (title, article, ownerID) VALUES (?, ?, ?)");
    $query->bind_param("ssi", $title, $article, $ownerID);
    $query->execute();

    $id = $con->query("SELECT id FROM articles order by id desc limit 1")->fetch_assoc();
    $con->close();
    header("location: article.php?id=".$id['id']);
    exit;
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
    <?php
    if(isset($editarticle)){
        echo "<title>Edit article</title>";
    }
    else{
        echo "<title>Create new article</title>";
    }
    ?>
</head>
<body>
    <?php getNav($role);?>
    <div class="container">
        <main class="managearticle">
            <form action="managearticle.php.php" method="post">
                <?php
                if(isset($editarticle)){
                    $title = $editarticle['title'];
                    $article = $editarticle['article'];
                    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">
                    <input type=\"text\" placeholder=\"Title\" value=\"$title\" name=\"title\">
                    <textarea name=\"article\" placeholder=\"Put your entire article here, the area can be resized if prefered\">$article</textarea>
                    <input type=\"submit\" value=\"Save and update\">";
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