<?php
include_once 'Donnees.inc.php';

function afficheEtoile ($a){

    $renv = '' ; 
    for ( $i = 0 ; $i < $a ; $i++){
        $renv = $renv . "🌟" ; 
    }
    return $renv ; 
}

function getSousCategories(array $ingredients, array $Hierarchie ): array {

    $nouveauxIngredients = $ingredients;
    $nouveau = false;

    // Tableau d'ingrédients
    foreach ($ingredients as $ingreParent) {
        
        // Maj première lettre
        $key = ucfirst($ingreParent);

        // Si il a une sous-categorie
        if (isset($Hierarchie[$key]) && isset($Hierarchie[$key]['sous-categorie'])) {
            $data = $Hierarchie[$key];
            
            // Recherches des sous-catégories 
            foreach ($data['sous-categorie'] as $ingreEnfant) {
                $ingreEnfantLower = strtolower($ingreEnfant);
                
                // Si nouvelle sous-catégories
                if (!in_array($ingreEnfantLower, $nouveauxIngredients)) {
                    $nouveauxIngredients[] = $ingreEnfantLower;
                    $nouveau = true;
                }
            }
        }
    }
    
    // Si pas de nouvelle catégories, alors plus besoin de faire une recherche
    if (!$nouveau) {
        return $nouveauxIngredients; 
    } else {
        return getSousCategories($nouveauxIngredients, $Hierarchie);
    }
}

if(isset($_GET['rech']) && $_GET['rech'] !== "") {

    $flags = -1 ; 

    $string = strtolower($_GET['rech']);

    $motsSaisis = explode(',', $string);
    $listeIngredients1 = [];

    // Retrait des espaces au cas ou 
    foreach ($motsSaisis as $mot) {
        $listeIngredients1[] = trim($mot);
    }

    $listeIngredients1 = getSousCategories($listeIngredients1, $Hierarchie);
    $listeIngredients1 = array_unique($listeIngredients1);

    echo "<ul>";
    if (!empty($listeIngredients1)) {

        foreach($Recettes as $cocktail) {
            
            $ingredientsCocktail = [] ; 

            foreach ( $cocktail['index'] as $index ){
                $ingredientsCocktail[] = strtolower($index);
            }

            // Vérifier s'il y a un match exact
            foreach ($listeIngredients1 as $ingreRecherche) {
                if (in_array($ingreRecherche, $ingredientsCocktail)) {
                    $flags = 1 ; 
                    echo '<li><a href="Recette.php?ingredient=' . $cocktail['titre'] . '">' .  htmlspecialchars($cocktail['titre']) . afficheEtoile($flags) .  '</a></li>';
                    $flags = 0 ; 
                    break;
                }
            }
        }
    }

    // Si le mot ne retourne rien, affiche des suggestions
    if ($flags === -1){
        foreach ($Hierarchie as $clef => $value){
            if ( str_contains(strtolower($clef), $string)){
                echo "<li><p style=\"color:#FF0000;\">" . htmlspecialchars($clef) . "</p></li>" ; 
            }
        }
    }

    echo "</ul>";

} else {
    // Affichage de toutes les recettes par default
    echo "<ul>";
    foreach($Recettes as $cocktail) {
        foreach($cocktail['index'] as $ingredient) {
                echo '<li><a href="Recette.php?ingredient=' . $cocktail['titre'] . '">' .  htmlspecialchars($cocktail['titre']) . '</a></li>';
                break ; 
        }
    }
    echo "</ul>";
}

?>