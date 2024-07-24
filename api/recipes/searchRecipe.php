<?php
require_once "../../conn/config.php";

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true"); // Ensure this header is present

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = $_GET['search'] ?? '';

    if ($search) {
        $stmt = $conn->prepare('SELECT id, name, ingredients, steps FROM recipes WHERE name LIKE ?');
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param('s', $searchTerm);
    } else {
        $stmt = $conn->prepare('SELECT id, name, ingredients, steps FROM recipes');
    }
    
    $stmt->execute();

    if ($stmt->error) {
        echo json_encode(["error" => "SQL Error: " . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();
    $recipes = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(["recipes" => $recipes]);
} else {
    echo json_encode(["error" => "Wrong request method"]);
}
?>
