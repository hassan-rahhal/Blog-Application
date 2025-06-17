<?php
// Enable error reporting for debugging - remove or comment out in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require '../connection.php';
require '../components/checkIfNotLogin.php';

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(['status' => 'error', 'result' => "Wrong request method"]);
    exit();
}

// Validate post_id existence
if (!isset($_POST['post_id'])) {
    echo json_encode(['status' => 'error', 'result' => "Missing post_id"]);
    exit();
}

$user_id = $_SESSION['userId'];
$post_id = $_POST['post_id'];

try {
    // Check if the like already exists
    $sql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":post_id", $post_id);
    $stmt->execute();
    $like = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($like) {
        // If like exists, remove it (unlike)
        $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":post_id", $post_id);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'result' => "Unlike"]);
    } else {
        // Else add a like
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":post_id", $post_id);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'result' => "Like"]);
    }
} catch (PDOException $ex) {
    // Return error message in JSON
    echo json_encode(['status' => 'error', 'result' => $ex->getMessage()]);
}

exit();
