<?php
session_start();
require("php/connection.php");
require("php/functions.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = checkSession($con);
if(!isset($user)){
    header("location: index.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = $page <= 0 ? 1 : $page;
$offset = ($page - 1) * 5;

$role = $user['role'];

if(isset($_GET['perm']) && isAdmin($role)){
    $articleCount = $con->query("SELECT COUNT(*) FROM articles")->fetch_row()[0];

    $query = $con->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT 5 OFFSET ?");
    $query->bind_param("i", $offset);
    $query->execute();
    $result = $query->get_result();
    
    $articles = $result->fetch_all(MYSQLI_ASSOC);
}
else{
    $ownerID = $user['id'];
    $articleCount = $con->query("SELECT COUNT(*) FROM articles where ownerid=$ownerID")->fetch_row()[0];

    $query = $con->prepare("SELECT * FROM articles WHERE ownerid=? ORDER BY id DESC LIMIT 5 OFFSET ?");
    $query->bind_param("ii",$ownerID, $offset);
    $query->execute();
    $result = $query->get_result();

    $articles = $result->fetch_all(MYSQLI_ASSOC);
}

$con->close();
$role = getRole($user);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My Articles</title>
</head>
<body>
    <?php
    getNav($role);
    ?>
    <div class="container">
        <div id="pagebuttons">
                <button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='myarticles.php?page=<?php echo $page-1;if(isAdmin($role))echo "&perm=admin";?>'">Previous</button>
                <button <?php echo $offset + 5 >= $articleCount ? 'disabled' : ''; ?> onClick="location.href='myarticles.php?page=<?php echo $page+1;if(isAdmin($role))echo "&perm=admin";?>'">Next</button>
        </div>
        <main class="myarticles">
            <?php
            foreach($articles as $article){
                $id = $article['id'];
                echo '<div>
                <h1>'.$article['title'].'</h1>
                <p>'.substr(parseMarkup($article['article']),0,500)."...</p>
                <button onclick=\"location.href='article.php?id=$id'\">Article page</button>
                <button onclick=\"location.href='managearticle.php?id=$id'\">Edit</button>
                <button onclick=\"location.href='managearticle.php?id=$id&delete=true'\">Remove</button>
             </div>";
            }
            ?>
        </main>
        <div id="pagebuttons">
                <button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='myarticles.php?page=<?php echo $page-1;if(isAdmin($role))echo "&perm=admin";?>'">Previous</button>
                <button <?php echo $offset + 5 >= $articleCount ? 'disabled' : ''; ?> onClick="location.href='myarticles.php?page=<?php echo $page+1;if(isAdmin($role))echo "&perm=admin";?>'">Next</button>
        </div>
    </div>
    <?php
    getFooter($role);
    ?>
</body>
</html>