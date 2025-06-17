<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loggedIn = false;
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
    $loggedIn = true;
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">RAHHAL BLOG</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php 
                    if(!$loggedIn){
                        echo '
                        <li>
                            <a href="index.php">News Feed</a>
                        </li>
                        <li>
                            <a href="login.php">Login</a>
                        </li>
                        <li>
                            <a href="register.php">Register</a>
                        </li>
                        ';
                    } else {
                        echo '
                        <li>
                            <a href="author.php?id='.$_SESSION['userId'].'">'. $_SESSION['username'].'</a>
                        </li>
                        <li>
                            <a href="index.php">News Feed</a>
                        </li>
                        <li>
                            <a href="newpost.php">New Post</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                        ';                        
                    }
                ?>

            </ul>
        </div>
    </div>
</nav>