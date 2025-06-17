<?php 
session_start();
require '../connection.php';
require '../components/checkIfNotLogin.php';
if($_SERVER['REQUEST_METHOD'] != "POST"){
    die("Wrong Method");
}

$fileType = strtolower(pathinfo($_FILES['profile']['name'], flags: PATHINFO_EXTENSION));
$image_name = "IMG_" . $_SESSION['userId'] . "_" . bin2hex(random_bytes(10)) . "." . $fileType;
$target = "../imgs/" . $image_name;

if($fileType != "jpeg" && $fileType != "png" && $fileType != "jpg" && $fileType != "gif"){
    header("Location: ../update_profile.php?err=2");
    exit();
}

while(file_exists($target)){
    $image_name = "IMG_" . $_SESSION['userId'] . "_" . bin2hex(random_bytes(10)) . "." . $fileType;
    $target = "../imgs/" . $image_name;
}

if($_FILES['profile']['size'] > 1000000){
    header("Location: ../update_profile.php?err=3");
    exit();
}

if(!getimagesize($_FILES['profile']['tmp_name'])){
    header("Location: ../update_profile.php?err=4");
    exit();
}

try{
    if(!move_uploaded_file($_FILES['profile']['tmp_name'], $target)){
        header("Location: ../update_profile.php?err=1");
        exit();
    }
    

    $sql = "UPDATE users SET profile = :profile WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":profile", $image_name);
    $stmt->bindParam(":id", $_SESSION['userId']);
    $stmt->execute();
    header("Location: ../index.php");
    exit();
} catch(Exception $ex){
    header("Location: ../update_profile.php?err=0");
    exit();
}