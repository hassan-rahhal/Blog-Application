<?php 
require '../connection.php';
require '../components/checkIfLogin.php';
if($_SERVER['REQUEST_METHOD'] != "POST"){
    die("Wrong Method");
}

$name = htmlspecialchars(trim($_POST['username']));
$email = htmlspecialchars(trim($_POST['email']));
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

if((!isset($email) || empty($email) ||
    (!isset($password) || empty(trim($password))) ||
    (!isset($name) || empty($name)))){
        header("Location: ../register.php?err=1");
        exit();
}

$_SESSION['register_name'] = $name;
$_SESSION['register_email'] = $email;

if(!filter_var($email, filter: FILTER_VALIDATE_EMAIL)){
    header("Location: ../register.php?err_email=2");
    exit();
}
if($password !== $password_confirmation){
    header("Location: ../register.php?err=5");
    exit();
}
if(strlen($password) < 8){
    header("Location: ../register.php?err=3");
        exit();
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(param: ":name", var: $name);
    $stmt->bindParam(param: ":password", var: $hashed_password);
    $stmt->bindParam(param: ":email", var: $email);
    $stmt->execute();
    $_SESSION['loggedIn'] = true;
    $_SESSION['userId'] = $pdo->lastInsertId();
    $_SESSION['username'] = $name;
    header("Location: ../index.php");
    exit();
} catch(PDOException $exc){
    if($exc->errorInfo[1] == 1062){
        header("Location: ../register.php?err=4");
        exit();
    } else {
        header("Location: ../register.php?err=0");
        exit();
    }
}