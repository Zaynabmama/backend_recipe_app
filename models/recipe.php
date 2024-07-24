<?php

class Recipe {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAllRecipes() {
        $sql = "SELECT * FROM recipes";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();

            $recipes = []; 

           
            while ($row = $result->fetch_assoc()) {
                $recipes[] = $row;
            }
            
            $stmt->close();
            
            return $recipes; 
        } else {
            return [];
        }
    }
    public function addRecipe($title, $description, $instructions, $image, $user_id) {
        $stmt = $this->conn->prepare('INSERT INTO recipes ( title, description , instructions, image, user_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssi', $title, $description, $instructions, $image, $user_id);

        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

   
}
