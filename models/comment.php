<?php

class Comment {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment($recipe_id, $user_id, $comment) {
        $stmt = $this->conn->prepare('INSERT INTO comments (recipe_id, user_id, comment) VALUES (?, ?, ?)');
        $stmt->bind_param('iis', $recipe_id, $user_id, $comment);

        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false; 
        }
    }

   
}
