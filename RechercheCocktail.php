<?php
include_once 'Donnees.inc.php';

if(isset($_GET['rechRecette']) && $_GET['rechRecette'] !== "") {
    
    ehco " TETSTESTSETSTEST" ; 

    echo "TEST1"; 
    $string = strtolower($_GET['rechRecette']);
    foreach($cocktail['index'] as $ingredient) {
        foreach($cocktail['sous-categorie'] as $categ) {
                if(str_contains(strtolower($categ), $string)) {
                echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
                break ;     
            }
        }
    }

} else {

    echo "<ul>";
    foreach($Hierarchie as $nom => $classe) {
        echo "<li>$nom</li>";
    }
    echo "</ul>";

}

?>
