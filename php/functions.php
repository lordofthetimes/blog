<?php
require("php/connection.php");
function getNav($role){
    echo "<nav>
        <img id='logo' src='static/logo.png' alt='logo'>
        <div class='nav-buttons'>
            <button onclick=\"location.href='index.php'\">Home</button>
            <button onclick=\"location.href='article.php'\">Latest Article</button>
            <button onclick=\"location.href='#'\">About us</button>
            <button onclick=\"location.href='contact.php'\">Contact</button>";
    if(isAdmin($role)){
        echo "<button onclick=\"location.href='adminpanel.php'\">Admin Panel</button>";
    }
    if(isUser($role)){
        echo "<button onclick=\"location.href='createarticle.php'\">Create article</button>
        <button onclick=\"location.href='logout.php'\">Log out</button>";
    }
    else{
        echo "<button onclick=\"location.href='login.php'\">Log in</button>";
    }
    echo "</div>
        <img id='hamburger' src='static/hamburger.png' alt='hamburger'>
        <img id='x' src='static/x.png' alt='x'>
        </nav>";
}
function getFooter(){
    echo "<footer>
        <h1>HTML Structure</h1>
        <ul>
            <li>Articles</li>
            <li><span></span></li>
            <li><a href='index.php'>All articles</a></li>
            <li><a href='article.php'>Latest article</a></li>
        </ul>
        <ul>
            <li>Information</li>
            <li><span></span></li>
            <li><a href='#'>About us</a></li>
            <li><a href='contact.php'>Contact</a></li>
        </ul>
    </footer>
    <button onclick=\"scrollToTop()\" id=\"scroll\" style=\"display: none\">↑</button> 
    <script src=\"script.js\"></script>";
}
function checkSession($con){
    if(isset($_SESSION["user_id"])){
        $id = $_SESSION["user_id"];
        $result = mysqli_query($con,"SELECT * FROM users WHERE id = '$id';"); // INNER JOIN user_data ON user_data.userID = users.ID 
        if($result && mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result);
        }
    }
}
function isAdmin($role){
    return $role == "admin" ||  isSuperAdmin($role);
}
function isSuperAdmin($role){
    return $role == "superadmin";
}
function isUser($role){
    return $role == 'user' || isAdmin($role);
}
function getRole($user){
    if(isset($user['role'])){
        return $user['role'];
    }
    return 'none';
}