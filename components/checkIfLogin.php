<?php
session_start();

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
    header("Location: /blog-application/index.php");
}