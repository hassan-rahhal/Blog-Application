<?php
    session_start();
 require '../components/checkIfNotLogin.php';
 if(!$_SESSION['is_admin']){
    die("Access Denied");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAHHAL Blog Application</title>
</head>
<body>
    <h1>Admin Page</h1>
</body>
</html>