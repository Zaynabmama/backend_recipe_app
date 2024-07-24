<?php
require_once "../../conn/config.php";

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['name'], $data['ingredients'], $data['steps'])) {
        $name = $data['name'];
        $ingredients = $data['ingredients'];
        $steps = $data['steps'];

        //testt
        $user_id = 4;

        $stmt = $conn->prepare('INSERT INTO recipes (user_id, name, ingredients, steps) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isss', $user_id, $name, $ingredients, $steps);

        if ($stmt->execute()) {
            echo json_encode(["status" => "Recipe created successfully"]);
        } else {
            echo json_encode(["error" => "Error creating recipe: " . $stmt->error]);
        }
    } else {
        echo json_encode(["error" => "Name, ingredients, and steps are required"]);
    }
} else {
    echo json_encode(["error" => "Wrong request method"]);
}
