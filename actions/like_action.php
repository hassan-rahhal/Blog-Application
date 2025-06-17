<?php 
header("Content-Type: application/json");
require '../connection.php';
require '../components/checkIfNotLogin.php';
if($_SERVER['REQUEST_METHOD'] != "POST"){
    echo json_encode(['status' => 'error', 'result' => "Wrong request method"]);

}

$user_id = $_SESSION['userId'];
$post_id = $_POST['post_id'];

try {
    $sql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id= :post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id",$user_id);
    $stmt->bindParam(":post_id",$post_id);
    $stmt->execute();
    $like = $stmt->fetch(PDO::FETCH_ASSOC);
    if($like){
        $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id= :post_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id",$user_id);
        $stmt->bindParam(":post_id",$post_id);
        $stmt->execute();
        echo json_encode(['status' => 'success', 'result' => "Unlike"]);
    } else {
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id",$user_id);
        $stmt->bindParam(":post_id",$post_id);
        $stmt->execute();
        echo json_encode(['status' => 'success', 'result' => "Like"]);
    
    } 
    
} catch(PDOException $ex){
    echo json_encode(['status' => 'error', 'result' => $ex->getMessage()]);
}
exit();
