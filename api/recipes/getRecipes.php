<?php

require_once "../../conn/config.php";
require_once "../../models/recipe.php";

$recipeModel = new Recipe($conn);


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $recipes = $recipeModel->getAllRecipes();

    if (!empty($recipes)) {
        
        echo json_encode(["recipes" => $recipes]);
    } else {
        
        echo json_encode(["message" => "No recipes found"]);
    }
} else {
    echo json_encode(["error" => "Wrong request method"]);
}

