<?php 
session_start();
require '../connection.php';
require '../components/checkIfNotLogin.php';
if($_SERVER['REQUEST_METHOD'] != "POST"){
    die("Wrong Method");
}

$subject = htmlspecialchars(trim($_POST['subject']));
$content = htmlspecialchars(trim($_POST['content']));

if((!isset($subject) || empty($subject) ||
    (!isset($content) || empty(trim($content))))){
        header("Location: ../newpost.php?err=1");
        exit();
}

try {
    $sql = "INSERT INTO posts (subject, content, user_id) VALUES (:subject, :content, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":subject", $subject);
    $stmt->bindParam(":content",$content);
    $stmt->bindParam(":user_id",$_SESSION['userId']);

    $stmt->execute();
    header("Location: ../index.php");
} catch(PDOException $e){
    header("Location: ../newpost.php?err=0");
    exit();
}