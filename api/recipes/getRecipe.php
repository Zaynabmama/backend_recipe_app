<?php
require_once "../../conn/config.php";

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare('SELECT * FROM recipes WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $recipe = $result->fetch_assoc();
            echo json_encode($recipe);
        } else {
            echo json_encode(["error" => "Recipe not found"]);
        }
    } else {
        echo json_encode(["error" => "Recipe ID is required"]);
    }
} else {
    echo json_encode(["error" => "Wrong request method"]);
}
?>
