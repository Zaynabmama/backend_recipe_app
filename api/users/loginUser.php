<?php
require_once "../../conn/config.php";

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $json = file_get_contents('php://input');// because we sent json

    
    $data = json_decode($json, true);

    
    if (isset($data['email'], $data['password'])) {
        $email = $data['email'];
        $password = $data['password'];

      
        $stmt = $conn->prepare('SELECT user_id, email, password FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();

       
        if ($stmt->error) {
            echo json_encode(["error" => "SQL Error: " . $stmt->error]);
            exit;
        }

        $stmt->store_result();
       
        if ($stmt->num_rows == 1) {
            
            $stmt->bind_result($user_id, $email, $hashed_password);
            $stmt->fetch();
            
          
            if (password_verify($password, $hashed_password)) {
               
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;

                
                echo json_encode([
                    "status" => "authenticated",
                    "id" => $user_id,
                    "email" => $email
                ]);
            } else {
                
                echo json_encode(["status" => "wrong password"]);
            }
        } else {
            
            echo json_encode(["status" => "user not found"]);
        }
    } else {
        
        echo json_encode(["error" => "Email and password are required"]);
    }
} else {
    
    echo json_encode(["error" => "Wrong request method"]);
}
?>
