<?php
session_start();
require('php/connection.php');
include('php/functions.php');

$user = checkSession($con);
if(!isset($user)){
    header("location: index.php");
    exit;
}
$role = getRole($user);

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['bio'])){
        $query = $con->prepare("UPDATE user_data SET bio = ? WHERE userID = ?");
        $query->bind_param("si",$_POST['bio'],$user['id']);
        $query->execute();
        
        $user['bio'] = $_POST['bio'];
    }
}
if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
}
else{
    $mode = 'none';
}
$query = $con->prepare("SELECT count(*) FROM articles WHERE ownerID = ?");
$query->bind_param("i",$user['id']);
$query->execute();
$articlesCount = $query->get_result()->fetch_row()[0];

$query = $con->prepare("SELECT date FROM articles WHERE ownerID = ? ORDER BY id DESC LIMIT 1");
$query->bind_param("i",$user['id']);
$query->execute();
$lastPosted = $query->get_result()->fetch_row()[0];

$query = $con->prepare("SELECT DATEDIFF(NOW(), accAge) AS accAge FROM user_data WHERE userID = ? LIMIT 1");
$query->bind_param("i",$user['id']);
$query->execute();
$accAge = $query->get_result()->fetch_row()[0];
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
    <title>My Profile</title>
</head>
<body>
    <?php
    getNav($role);
    ?>
    <div class="container">
        <main class="profile">
                <div id='account'>
                    <div>Last Posted: <?php echo $lastPosted;?></div>
                    <div>Total Articles: <?php echo $articlesCount;?></div>
                    <div>Account Age: <?php echo $accAge;?> days</div>
                    <?php
                    if($mode == 'editbio'){
                    ?>
                        <form method='post' action='profile.php'>
                            <textarea name='bio'><?php echo $user['bio'];?></textarea>
                            <button type="submit">Save bio</button>
                        </form>
                    <?php
                    }
                    else{
                    ?>
                        <div id='bio'><?php echo $user['bio'];?></div>
                        <button onClick="location.href='profile.php?mode=editbio'">Change Bio</button>
                    <?php
                    }
                    ?>
                </div>
                <div id='user'>
                    <?php
                    if($mode == 'edituser'){
                    ?>
                    <?php
                    }
                    else{
                    ?>
                        <div>User: <?php echo $user['login'];?></div>
                        <div>Name: <?php echo $user['name'];?></div>
                        <div>Surname: <?php echo $user['surname'];?></div>
                        <div>Age: <?php echo $user['age']; ?></div>
                        <div>Gender: <?php echo $user['gender'];?></div>
                    <?php
                    }
                    ?>
                </div>
                <aside>
                    <img src="static/pfp/<?php echo $user['pfp']; ?>" alt="Profile picture" width="150vw" height="150vh">
                    <button onClick="location.href='php/changepassword.php'">Change password</button>
                </aside>
        </main>
    </div>
    <?php
    getFooter($role);
    ?>
</body>
</html>