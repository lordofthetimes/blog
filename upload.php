<?php
session_start();
require("php/connection.php");
include("php/functions.php");




$user = checkSession($con);

if(!isset($user)){
    header("location: index.php");
    exit;
}





if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['upload'])) {

    $maxSize = 5 *1024 * 1024;
    $allowedExtension = array('jpg','jpeg','png','svg','gif','webp');
    $extension = strtolower(pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION));

    $mode = null;
    if($_GET['upload'] == 'profile'){
        $path = 'static/pfp/';
        $targetFile = "pfp_".$user['login'].".".$extension;
        $header = 'profile.php?';
        $mode = 'profile';
    }
    if($_GET['upload'] == 'baner' && isset($_GET['header'])){
        $path = 'static/articles/';
        $targetFile = "art_".uniqid()."_".$user['login'].".".$extension;
        $header = urldecode($_GET['header']);
        $mode = 'article';
    }
    if(isset($_GET['old'])){
        $delete = basename(urldecode($_GET['old']));
    }
    else{
        $delete = 'default.png';
    }

    if ($_FILES["upload"]["error"] != UPLOAD_ERR_OK) {
        header("location: ".$header."&alert=ERR_UPLOAD_FAIL");
        exit;
    }

    if($_FILES['upload']['size'] > $maxSize){
        header("location: ".$header."&alert=ERR_FILE_SIZE");
        exit;
    }

    if(!in_array($extension,$allowedExtension)){
        header("location: ".$header."&alert=ERR_FILE_EXT");
        exit;
    }

    if($delete != 'default.png' && isset($delete)){
        if(!unlink($path.$delete)){
            header("location: ".$header."&alert=ERR_REM_FAIL");
            exit;
        }
    }

    if(move_uploaded_file($_FILES["upload"]["tmp_name"],$path.$targetFile)){

        if($mode == 'profile'){
            $query = $con->prepare("UPDATE user_data SET pfp = ? WHERE userID = ?");
            $query->bind_param("si",$targetFile,$user['id']);
            $query->execute();

            header("location: ".$header);
        }
        if($mode == 'article'){
            header("location: ".$header."&baner=".urlencode($targetFile));
        }
        exit;
    }
    else{
        // $query = $con->prepare("UPDATE user_data SET pfp = 'default.png' WHERE userID = ?");
        // $query->bind_param("i", $user['id']);            $query->execute();
        header("location: ".$header."&alert=ERR_MOVE_FAIL");
        exit;
    }
}

?>