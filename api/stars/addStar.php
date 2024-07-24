
<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_id = $_SESSION['user_id'];
    $recipe_id = $data['recipe_id'];
    $action = $data['action'];

    if ($action === 'like') {
        $query = "INSERT INTO likes (user_id, recipe_id) VALUES (:user_id, :recipe_id)";
    } else {
        $query = "DELETE FROM likes WHERE user_id = :user_id AND recipe_id = :recipe_id";
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':recipe_id', $recipe_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
