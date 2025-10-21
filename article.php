<?php
session_start();
require("php/connection.php");
require("php/functions.php");

$user = checkSession($con);
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    $query = $con->prepare("SELECT * FROM articles WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $articleResult = $query->get_result();

    if($articleResult){
        $articleData = $articleResult->fetch_assoc();
    }
}
else{
    $articleData = $con->query("SELECT * FROM articles ORDER BY id DESC LIMIT 1")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Article</title>
</head>
<body>
    <?php
    getNav(getRole($user));
    ?>
    <div class="container">
        <main class="article">
             <article>
                <?php
                if(isset($articleData)){
                    echo '<h2>'.$articleData['title'].'</h2>
                    <p>'.$articleData['article'].'</p>';
                    if (isset($user)) {
                        if($articleData['ownerID'] == $user['id'] || isAdmin(getRole($user))){
                            echo "
                                <button onclick=\"location.href='managearticle.php?id=$id'\">Edit</button>
                                <button onclick=\"location.href='managearticle.php?id=$id&delete=true'\">Remove</button>";
                        }
                    }
                }
                else{
                    echo '<h2>Article not found</h2>
                    <p>The article you are looking for does not exist.</p>';
}
                ?>
            </article>
        </main>
    </div>
    <?php
    getFooter();
    ?>
</body>
</html>