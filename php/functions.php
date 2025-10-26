<?php
require("php/connection.php");
function getNav($role){
    echo "<nav>
        <img id='logo' src='static/logo.png' alt='logo'>
        <div class='nav-buttons'>
            <button onclick=\"location.href='index.php'\">Home</button>
            <button onclick=\"location.href='article.php'\">Latest Article</button>
            <button onclick=\"location.href='contact.php'\">Contact</button>";
    
    if(isUser($role)){
        echo "<button onclick=\"location.href='myarticles.php'\">My Articles</button>
        <button onclick=\"location.href='managearticle.php'\">Create Article</button>";
        if(isAdmin($role)){
            echo "<button onclick=\"location.href='adminpanel.php'\">Admin Panel</button>";
        }
        echo "<button onclick=\"location.href='logout.php'\">Log out</button>";
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
        
        $query = $con->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result(); // INNER JOIN user_data ON user_data.userID = users.ID

        if($result && mysqli_num_rows($result) > 0){
            return $result->fetch_assoc();
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
function parseMarkup($article){
    $article = str_replace(['\#', '\*'], ['__ESC_HASH__', '__ESC_ASTERISK__'], $article);
    $article = preg_replace("/^######\s+(.*)$/m","<h6>$1</h6>",$article);
    $article = preg_replace("/^#####\s+(.*)$/m","<h5>$1</h5>",$article);
    $article = preg_replace("/^####\s+(.*)$/m","<h4>$1</h4>",$article);
    $article = preg_replace("/^###\s+(.*)$/m","<h3>$1</h3>",$article);
    $article = preg_replace("/^##\s+(.*)$/m","<h2>$1</h2>",$article);
    $article = preg_replace("/^#\s+(.*)$/m","<h1>$1</h1>",$article);
    $article = preg_replace("/\*\*(.*?)\*\*/",'<b>$1</b>',$article);
    $article = preg_replace("/\*(.*?)\*/","<i>$1</i>",$article);
    $article = str_replace(['__ESC_HASH__', '__ESC_ASTERISK__'], ['<span>#</span>', '<span>*</span>'], $article);
    return $article;
}
function clearMarkup($article){
    $article = str_replace(['\#', '\*'], ['__ESC_HASH__', '__ESC_ASTERISK__'], $article);
    $article = preg_replace("/^######\s+(.*)$/m","$1",$article);
    $article = preg_replace("/^#####\s+(.*)$/m","$1",$article);
    $article = preg_replace("/^####\s+(.*)$/m","$1>",$article);
    $article = preg_replace("/^###\s+(.*)$/m","$1",$article);
    $article = preg_replace("/^##\s+(.*)$/m","$1",$article);
    $article = preg_replace("/^#\s+(.*)$/m","$1",$article);
    $article = preg_replace("/\*\*(.*?)\*\*/","$1",$article);
    $article = preg_replace("/\*(.*?)\*/","$1",$article);
    $article = str_replace(['__ESC_HASH__', '__ESC_ASTERISK__'], ['#', '*'], $article);
    return $article;
}