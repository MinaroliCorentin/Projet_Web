<?php
include_once 'Donnees.inc.php';

if(isset($_GET['rech']) && $_GET['rech'] !== "") {
    $string = strtolower($_GET['rech']);
    $listeIngredients = [] ; 

    foreach ($Hierarchie as $categorie => $data) {
        if (strtolower($categorie) === $string) {
            
            $listeIngredients[] = $string;

            foreach ($data['sous-categorie'] as $ingre) {
                $listeIngredients[] = strtolower($ingre); 
            }
        }
    }
    
    // Si l'aliment n'a pas de sous catégories
    if (empty($listeIngredients)) {
        $listeIngredients = $string;
    }

    // Retire les doublons
    $listeIngredients = array_unique($listeIngredients);

    // 3. Affichage des recettes
    echo "<ul>";
    // Si la liste contient l'ingrédient recherché ou les sous-catégories, on filtre les recettes.
    if (!empty($listeIngredients)) {
        foreach($Recettes as $cocktail) {
            
            // On s'assure que les ingrédients de la recette sont aussi en minuscule pour la comparaison
            $ingredientsCocktail = [] ; 
            foreach ( $cocktail['index'] as $index ){
                $ingredientsCocktail[] = strtolower($index);
            }

            // On verifie si un ingredient ou sa sous-liste est presente dans la liste des ingredients de X cocktail
            foreach ($listeIngredients as $ingreRecherche) {
                if (in_array($ingreRecherche, $ingredientsCocktail)) {
                    echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
                    break;
                }
            }
        }
    }
    echo "</ul>";

} else {
    // Affichage de toutes les recettes par default
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