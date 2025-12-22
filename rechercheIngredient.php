<?php
include_once 'Donnees.inc.php';

function afficheEtoile ($a){

    $renv = '' ; 
    for ( $i = 0 ; $i < $a ; $i++){
        $renv = $renv . "🌟" ; 
    }
    return $renv ; 
}

function afficheEtoileDark ($a){

    $renv = '' ; 
    for ( $i = 0 ; $i < $a ; $i++){
        $renv = $renv . "✶" ; 
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
    $listeIngredientRefus = [] ; 

    foreach ($motsSaisis as $mot) {
        $listeIngredients1[] = trim($mot);
    }

    foreach($listeIngredients1 as $key => $ingre){
        if (str_contains($ingre, "!")){
            $listeIngredientRefus[] = ltrim($ingre, "!");          
            unset($listeIngredients1[$key]); // Supprime de la liste "voulue"
        }
    }

    $listeIngredients1 = getSousCategories($listeIngredients1, $Hierarchie);
    $listeIngredientRefus = getSousCategories($listeIngredientRefus, $Hierarchie);

    $listeIngredients1 = array_unique($listeIngredients1);
    $listeIngredientRefus = array_unique($listeIngredientRefus);

    echo "<ul>";
    
    foreach($Recettes as $cocktail) {
        $etoiles = 0; 
        $etoilesDark = 0 ; 
        $ingredientsCocktail = []; 
        
        foreach ($cocktail['index'] as $index){
            $ingredientsCocktail[] = strtolower($index);
        }

        foreach ($listeIngredients1 as $ingreRecherche) {
            if (in_array($ingreRecherche, $ingredientsCocktail)) {
                $etoiles++; 
            }
        }

        foreach ($listeIngredientRefus as $ingreRefus) {
            if (in_array($ingreRefus, $ingredientsCocktail)) {
                $etoilesDark++; 
            }
        }

        // On affiche si le cocktail un element voulu 
        if ($etoiles > 0) {
            $flags = 1; 
            echo '<li><a href="Recette.php?ingredient=' . urlencode($cocktail['titre']) . '">' .  
                htmlspecialchars($cocktail['titre']) . " " . 
                afficheEtoile($etoiles) . 
                afficheEtoileDark($etoilesDark) . 
                '</a></li>';
        }
    }

    // Si aucun match 
    if ($flags === -1){
        foreach ($Hierarchie as $clef => $value){
            if (str_contains(strtolower($clef), $string)){
                echo "<li><p style=\"color:#FF0000;\">" . htmlspecialchars($clef) . "</p></li>" ; 
            }
        }
    }
    echo "</ul>";
} else {

    echo "<ul>";
    foreach($Recettes as $cocktail) {
        echo '<li><a href="Recette.php?ingredient=' . urlencode($cocktail['titre']) . '">' . htmlspecialchars($cocktail['titre']) . '</a></li>';
    }
    echo "</ul>";
}
?>