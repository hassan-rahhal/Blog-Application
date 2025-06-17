<?php 
session_start();
require '../connection.php';
require '../components/checkIfNotLogin.php';
if($_SERVER['REQUEST_METHOD'] != "POST"){
    die("Wrong Method");
}

$content = htmlspecialchars(trim($_POST['content']));
$post_id = $_POST['post_id'];
$user_id = $_SESSION['userId'];
$comment_id = empty($_POST['comment_id']) ? null : $_POST['comment_id'];

//Check for post_id
if(!isset($content) || empty(trim($content)) || !isset($post_id) || empty(trim($post_id))){
        die("Wrong parameters");
        exit();
}

$sql = "INSERT INTO comments (content, user_id, post_id, comment_id) VALUES (:content, :user_id, :post_id, :comment_id)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":content", $content);
$stmt->bindParam(":user_id",$user_id);
$stmt->bindParam(":post_id",$post_id);
$stmt->bindParam(":comment_id",$comment_id);

$stmt->execute();
header("Location: ../post.php?id=$post_id");
exit();