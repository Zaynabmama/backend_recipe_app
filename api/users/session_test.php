<?php
require_once "../../conn/config.php";

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
session_start();

if (isset($_SESSION['user_id'])) {
    echo "User ID: " . $_SESSION['user_id'];
} else {
    echo "No user ID set in session.";
}
?>
