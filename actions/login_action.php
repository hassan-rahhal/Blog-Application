<?php 
require '../connection.php';
require '../components/checkIfLogin.php';
if($_SERVER['REQUEST_METHOD'] != "POST"){
    die("Wrong Method");
}

$email = trim($_POST['email']);
$password = $_POST['password'];

if((!isset($email) || empty($email) ||
    (!isset($password) || empty(trim($password))))){
        header("Location: ../login.php?err=1");
        exit();
}

try {
    $sql = "SELECT id, name, password, is_admin FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(param: ":email", var: $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$user){
        header("Location: ../login.php?err=2");
        exit();
    }

    if(!password_verify($password, $user['password'])){
        header("Location: ../login.php?err=3");
        exit();
    }
    
    $_SESSION['loggedIn'] = true;
    $_SESSION['userId'] = $user["id"];
    $_SESSION['username'] = $user['name'];
    $_SESSION['is_admin'] = $user['is_admin'];
    header("Location: ../index.php");
    exit();
} catch(PDOException $exc){
        header("Location: ../login.php?err=0");
        exit();
}