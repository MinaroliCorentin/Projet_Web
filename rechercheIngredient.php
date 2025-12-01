<?php
include_once 'Donnees.inc.php';

if(isset($_GET['rech']) && $_GET['rech'] !== "") {
    $string = strtolower($_GET['rech']);
    echo "<ul>";
    foreach($Recettes as $cocktail) {
        foreach($cocktail['index'] as $ingredient) {
            if(str_contains(strtolower($ingredient), $string)) {
                echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
                break; 
            }
        }
    }
    echo "</ul>";
} else {
    echo "<ul>";
    foreach($Recettes as $cocktail) {
        foreach($cocktail['index'] as $ingredient) {
                echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
                break ; 
        }
    }
    echo "</ul>";

}

?>