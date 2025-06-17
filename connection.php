<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "youbeeblog5";
try {
    $pdo = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $exc){
    die("Connection to database failed! Error: " . $exc->getMessage());
}