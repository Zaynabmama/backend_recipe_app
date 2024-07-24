<?php
require_once "../../conn/config.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];


    $check_email = $conn->prepare('SELECT user_id FROM users WHERE username=? OR email=?');
    $check_email->bind_param('ss', $username, $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["error" => "Username or email already exists"]);
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $username, $email, $hashed_password);
        $stmt->execute();

        $res['status'] = "success";
        $res['message'] = "Inserted successfully";
        echo json_encode($res);
    }
} else {
    echo json_encode(["error" => "Wrong request method"]);
}
