<?php
session_start();
require("php/connection.php");
require("php/functions.php");

$user = checkSession($con);
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    $query = $con->prepare("SELECT c.category,a.id, u.login, a.ownerID, a.title, a.article, a.date 
    FROM articles a join users u on u.id = a.ownerID join categories c on a.categoryID=c.categoryID WHERE a.id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $articleResult = $query->get_result();

    if($articleResult){
        $articleData = $articleResult->fetch_assoc();
    }
}
else{
    $articleData = $con->query("SELECT c.category, a.id, u.login, a.ownerID, a.title, a.article, a.date  
    FROM articles a join users u on a.ownerID = u.id join categories c on a.categoryID=c.categoryID 
    ORDER BY a.id DESC LIMIT 1")->fetch_assoc();
}
$role = getRole($user);
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
    getNav($role);
    ?>
    <div class="container">
        <main class="article">
             <article>
                <?php
                if(isset($articleData)){
                    echo '<h1>'.$articleData['title'].'</h1>
                    <p id="date">'.$articleData['login'].'</p>
                    <p id="date">'.$articleData['date'].' | '.$articleData['category'].'</p>
                    <p>'.parseMarkup($articleData['article']).'</p>';
                    if (isset($user)) {
                        // echo "<button onclick=\"location.href='managearticle.php?id=$id'\">Comment</button>";
                        if($articleData['ownerID'] == $user['id'] || isAdmin(getRole($user))){
                            if(!isset($id)){
                                $id = $articleData['id'];
                            }
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
    getFooter($role);
    ?>
</body>
</html>