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
if(!isAdmin($role)){
    header("location: index.php");
    exit;
}

if(isset($_GET['changePerms'])){
    $login = $_GET['changePerms'];

    if(isset($login)){
        $query = $con->prepare("SELECT * FROM users WHERE login=? limit 1");
        $query->bind_param("s", $login);
        $query->execute();
        $result = $query->get_result();
        
        if($result){
            $changedUser = $result->fetch_assoc();
            if(!isSuperAdmin(getRole($changedUser))){
                if(isAdmin(getRole($changedUser))){
                    $setRole = 'user';
                }
                else{
                    $setRole = 'admin';
                }
                $query = $con->prepare("UPDATE users SET role = ? WHERE id = ?");
                $query->bind_param("si", $setRole, $changedUser['id']);
                $query->execute();
                header("location: adminpanel.php");
                exit;
            }
        }
    }
}
$userCount = $con->query("SELECT COUNT(*) FROM users")->fetch_row()[0];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

$query = $con->prepare("SELECT * FROM users ORDER BY id ASC LIMIT ? OFFSET ?");
$query->bind_param("ii", $perPage, $offset);
$query->execute();
$result = $query->get_result();
if(!$result){
    echo "No results for selecting users";
    die;
}
$users = $result->fetch_all(MYSQLI_ASSOC); 
$con->close();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Panel</title>
</head>
<body>
    <?php getNav($role);?>
    <div class="container">
        <main class="adminpanel">
        <table>
            <?php
                foreach($users as $user) {
                $login = $user['login'];
                $userRole = $user['role'];
                ?>
                <tr>
                    <td>Login : <?php echo $login; ?></td>
                    <td>Role : <?php echo $userRole; ?></td>
                    <td>
                    <?php
                        if(!isSuperAdmin($userRole)){
                            ?>
                            <button onClick="location.href='adminpanel.php?changePerms=<?php echo $login; ?>'">
                                <?= isAdmin($userRole) ? "Remove admin" : "Add admin"; ?>
                            </button>
                            <?php
                        }
                        else{
                            ?>
                            <button>Cannot change</button>
                            <?php
                        }
                    ?>
                    </td>
                </tr>
            <?php 
            } 
            ?>
            <tr id="adminpagebuttons">
                <td><button <?php echo $page - 1 <=0 ? 'disabled' : ''; ?> onClick="location.href='adminpanel.php?page=<?php echo $page -1; ?>'">Previous</button></td>
                <td></td>
                <td><button <?php echo $offset + $perPage >= $userCount ? 'disabled' : ''; ?> onClick="location.href='adminpanel.php?page=<?php echo $page + 1; ?>'">Next</button></td>
        </tr>
        </table>
        </main>
    </div>
            
    <?php getFooter($role);?>
</body>
</html>