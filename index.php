<?php
session_start();
require("php/connection.php");
require("php/functions.php");

$user = checkSession($con);

$articleCount = $con->query("SELECT COUNT(*) FROM articles")->fetch_row()[0];

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = $page <= 0 ? 1 : $page;
$offset = ($page - 1) * 12;

$query = $con->prepare("SELECT a.id, u.login, a.ownerID, a.title, a.article, a.date 
FROM articles a join users u on u.id = a.ownerID ORDER BY a.id DESC LIMIT 12 OFFSET ?");
$query->bind_param("i", $offset);
$query->execute();
$result = $query->get_result();

$articles = $result->fetch_all(MYSQLI_ASSOC);

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
        <div id="pagebuttons">
                <button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page -1; ?>'">Previous</button>
                <button <?php echo $offset + 12 >= $articleCount ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page + 1; ?>'">Next</button>
        </div>
        <main class="index">
            <?php
            foreach($articles as $article){
                echo '<div>
                <h3>'.substr($article['title'],0,50).'</h3>
                <p id="date">'.$article['login'].' | '.$article['date'].'</p>
                <p>'.substr(clearMarkup($article['article']),0,100).'...</p>
                <a href="article.php?id='.$article['id'].'">Read more →</a>
             </div>';
            }
            ?>
        </main>
        <div class="mobile" id="pagebuttons">
                <button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page -1; ?>'">Previous</button>
                <button <?php echo $offset + 12 >= $articleCount ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page + 1; ?>'">Next</button>
        </div>
    </div>
    <?php
    getFooter();
    ?>
</body>
</html>