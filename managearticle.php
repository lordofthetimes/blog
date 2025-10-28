<?php
session_start();

require('php/connection.php');
include('php/functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = checkSession($con);

if(!isset($user)){
    header("location: index.php");
    exit;
}

$categories = $con->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $query = $con->prepare("SELECT * FROM articles WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    if($result->num_rows > 0){

        $editarticle = $result->fetch_assoc();
        if(!($editarticle['ownerID'] == $user['id'] || isAdmin(getRole($user)))){
            header("location: index.php");
            exit;
        }
        if(isset($_GET['delete']) && $_GET['delete'] == 'true'){

            $query = $con->prepare("DELETE FROM articles WHERE id = ?");
            $query->bind_param("i", $id);
            $query->execute();

            header("location: index.php");
            exit;
        }

    }
}
else if($_SERVER["REQUEST_METHOD"] == "POST"){

    $title = $_POST['title'];
    $article = $_POST['article'];
    $ownerID = $_POST['ownerID'];
    $baner = $_POST['baner'];
    $category = $_POST['category'];

    if( isset($_POST['id']) && ($ownerID == $user['id'] || isAdmin(getRole($user))) ){
        $id = $_POST['id'];
        $query = $con->prepare("UPDATE articles SET title = ?, article = ?, image = ?,categoryID = ? WHERE id = ?");
        $query->bind_param("sssii", $title, $article,$baner,$category, $id);
        $query->execute();

        header("location: article.php?id=".$id);
        exit;
    }
    $date = date("Y-m-d");
    $ownerID = $user['id'];
    $query = $con->prepare("INSERT INTO articles (title, article, ownerID, date,image,categoryID) VALUES (?, ?, ?, ?, ?,?)");
    $query->bind_param("ssissi", $title, $article, $ownerID, $date,$baner,$category);
    $query->execute();

    $id = $con->query("SELECT id FROM articles order by id desc limit 1")->fetch_assoc()['id'];
    $con->close();
    header("location: article.php?id=".$id);
    exit;
}

if(isset($_GET['baner'])){
    $baner = urldecode($_GET['baner']);
}
else{
    if(isset($editarticle['image'])){
        $baner = $editarticle['image'];
    }
    else{
        $baner = 'default.png';
    }
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
            <form action="managearticle.php" method="post">
                <input type="hidden" name="baner" value="<?php echo$baner;?>">
                <select name="category" required>
                <?php
                foreach($categories as $categoryOption){
                    echo "<option value=".$categoryOption['categoryID'];
                    if(isset($editarticle)){
                        if($categoryOption['categoryID'] == $editarticle['categoryID']){
                            echo " selected ";
                        }
                    }
                    else if($categoryOption['categoryID'] == 4){
                        echo " selected ";
                    }
                    echo ">".$categoryOption['category']."</option>";
                }
                ?>
                </select>
                <?php
                if(isset($editarticle)){
                    $title = $editarticle['title'];
                    $article = $editarticle['article'];
                    $ownerID = $editarticle['ownerID'];
                    echo "<input type=\"hidden\" name=\"id\" value=\"$id\" required>
                    <input type=\"hidden\" name=\"ownerID\" value=\"$ownerID\">
                    <input type=\"text\" placeholder=\"Title\" value=\"$title\" name=\"title\" required>
                    <textarea name=\"article\" placeholder=\"Put your entire article here, the area can be resized if prefered\" required>$article</textarea>
                    <input type=\"submit\" value=\"Save and update\">";
                }
                else{
                ?>
                    <input type="text" placeholder="Title" name="title" required>
                    <?php 
                    $ownerID = $user['id'];
                    echo "<input type=\"hidden\" name=\"ownerID\" value=\"$ownerID\" required>"; ?>
                    <textarea name="article" placeholder="Put your entire article here, the area can be resized if prefered"></textarea>
                    <input type="submit" value="Save and publish">
                <?php
                }
                ?>
                
            </form>
            <aside>
                <span><h2>Article Baner</h2></span>
                <img src="static/articles/<?php echo$baner;?>">
                <?php
                    $oldFile = urlencode($baner); 
                    $currentPage = urlencode(basename($_SERVER['PHP_SELF']) . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : ''));
                ?>
                <form action="upload.php?upload=baner&old=<?php echo $oldFile; ?>&header=<?php echo $currentPage; ?>" method="POST" enctype="multipart/form-data">                        <input id="upload" type="file" name="upload" required>
                        <button type="button" onCLick='document.getElementById("upload").click();'>Change Baner</button>
                        <button type="submit">Upload</button>
                </form>
            </aside>
        </main>
    </div>
    <?php getFooter($role);?>
</body>
</html>