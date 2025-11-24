<?php
include_once 'Donnees.inc.php';

# rechercherCocktailsParIngredient($String) {
if(isset($_GET['rech']) && $_GET['rech'] !== "") {
    $string = strtolower($_GET['rech']);
    echo "<ul>";
    foreach($Recettes as $cocktail) {
        foreach($cocktail['index'] as $ingredient) {
            if(str_contains(strtolower($ingredient), $string)) {
                echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
            }
        }
    }
    echo "</ul>";
} else {
    echo "<ul>";
    foreach($Recettes as $cocktail) {
        foreach($cocktail['index'] as $ingredient) {
                echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
        }
    }
    echo "</ul>";

}

# }

#if(isset($_GET['rech']) && $_GET['rech'] !== "") {
#rechercherCocktailsParIngredient($_GET['rech']);
# } 

?>
