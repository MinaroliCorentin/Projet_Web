<?php
include_once 'Donnees.inc.php';

if(isset($_GET['recette']) && $_GET['recette'] !== "") {
    
    $string = strtolower($_GET['recette']);
    $recette = htmlspecialchars($recette);

    echo "<h3>Resultat pour : " . $recette . "</h3>" ;

    foreach($Hierarchie as $categorie => $data){

        if ( strtolower($categorie == $recette)){

            if ( isset($data['sous-categorie'])){
                echo "<ul>";
                foreach($data['sous-categorie'] as $element){
                    echo "<li>" . htmlspecialchars($element) . "</li>" ; 
                }
                echo "</ul>";
            }
        }
    }
}

?>