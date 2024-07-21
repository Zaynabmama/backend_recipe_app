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

            $recipes = array();
            while ($row = $result->fetch_assoc()) {
                $recipes[] = $row;
            }
            
      
            $stmt->close();
            
            return $recipes;
        } else {
          
            return array();
        }
    }

   
}

?>
