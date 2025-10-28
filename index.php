<?php
session_start();
require("php/connection.php");
require("php/functions.php");

$user = checkSession($con);

$articleCount = $con->query("SELECT COUNT(*) FROM articles")->fetch_row()[0];

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = $page <= 0 ? 1 : $page;
$offset = ($page - 1) * 12;
$sortCategory = '1 or 1=1';
if(isset($_GET['sortCategory'])){
    if($_GET['sortCategory'] != 'none'){
        $sortCategory = $_GET['sortCategory'];
    }
}
$query = $con->prepare("SELECT c.category, c.categoryID,a.image,a.id,d.pfp, u.login, a.ownerID, a.title, a.article, a.date 
FROM articles a join users u on u.id = a.ownerID join categories c on a.categoryID=c.categoryID 
JOIN user_data d on d.userID = u.id WHERE c.categoryID = $sortCategory
ORDER BY a.id DESC LIMIT 12 OFFSET ?");
$query->bind_param("i", $offset);
$query->execute();
$result = $query->get_result();

$articles = $result->fetch_all(MYSQLI_ASSOC);

$categories = $con->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

$con->close();

$role= getRole($user);
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
    getNav($role);
    ?>
    <div class="container">
        <div id="pagebuttons">
                <button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page -1; ?>'">Previous</button>
                <button <?php echo $offset + 12 >= $articleCount ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page + 1; ?>'">Next</button>
        </div>
    <section>
        <main class="index">
            <?php
            foreach($articles as $article){
                echo '<div>
                <div class="article-image" style="background-image:url(\'static/articles/'.$article['image'].'\')">
                </div>
                <h3>'.substr($article['title'],0,50).'</h3>
                <div id="index-article">
                    <img src="static/pfp/'.$article['pfp'].'">
                    <div id="index-article-data">
                        <p id="date">'.$article['login'].'</p>
                        <p id="date">'.$article['date'].' | '.$article['category'].'</p>
                    </div>
                </div>
                <a href="article.php?id='.$article['id'].'">Read more →</a>
             </div>';
            }
            ?>
        </main>
        <aside>
            <form method="get"  action="index.php">
                <select  name='sortCategory'>
                    <option value ='none'>All</option>
                    <?php
                    foreach($categories as $categoryOption){
                        echo "<option value=".$categoryOption['categoryID'];
                        if(isset($_GET['sortCategory'])){
                            if ($categoryOption['categoryID'] == $_GET['sortCategory']) {
                                echo ' selected';
                            }
                        }
                        echo ">".$categoryOption['category']."</option>";
                    }
                    ?>
                </select>
                <button type='submit'>Sort</button>
            </form>
        </aside>
    </section>
        <div class="mobile" id="pagebuttons">
                <button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page -1; ?>'">Previous</button>
                <button <?php echo $offset + 12 >= $articleCount ? 'disabled' : ''; ?> onClick="location.href='index.php?page=<?php echo $page + 1; ?>'">Next</button>
        </div>
    </div>
    <?php
    getFooter($role);
    ?>
</body>
</html>