<?php

if (isset($_GET['nav'])) {
    $destination = $_GET['nav'];

    // Si on change de page, on ajoute l'étape actuelle à l'historique
    if (isset($_SESSION['nav']) && $_SESSION['nav'] != $destination) {

            // On ajoute à la suite avec un slash
            $_SESSION['Historique'] .= "/" . $_SESSION['nav'];
        
    }
    $_SESSION['nav'] = $destination;
}

// Réinitialisation via le bouton
if (isset($_GET['reset'])) {
    $_SESSION["nav"] = 'Aliment';
    $_SESSION['Historique'] = ''; 
}

if (isset($_SESSION["nav"]) && $_SESSION["nav"] !== "") {
    $actuel = $_SESSION["nav"];
    $historique = $_SESSION['Historique'];

    // Calcul du chemin complet : Historique + Element Actuel
    if ($historique === "") {
        // Si l'historique est vide, on affiche juste l'élément actuel
        $cheminAffiche = $actuel;
    } else {
        // Sinon, on concatène l'historique, un slash, et l'élément actuel
        $cheminAffiche = $historique . "/" . $actuel;
    }
    
    echo "<p class=\"test\">" . htmlspecialchars($cheminAffiche) . "</p>";
    echo "<h3>Résultats pour : " . htmlspecialchars($actuel) . "</h3>";

    $actuelMin = strtolower($actuel);
    foreach ($Hierarchie as $categorie => $info) {
        if (strtolower($categorie) === $actuelMin) {
            // affichage sous categories
            if (isset($info['sous-categorie'])) {
                echo "<ul>";
                foreach ($info['sous-categorie'] as $element) {
                    echo '<li><a href="index.php?nav=' . urlencode($element) . '">' . htmlspecialchars($element) . '</a></li>';
                }
                echo "</ul>";
            } else {
                // Affichage des cocktails
                echo "<ul>";
                foreach($Recettes as $cocktail) {
                    foreach($cocktail['index'] as $ingredient) {
                        if (strcasecmp(strtolower($ingredient), $categorie) === 0) {
                            echo '<a href="Recette.php?ingredient=' . urlencode($cocktail['titre']) . '" class="cocktail" data-nom="' . htmlspecialchars($cocktail['titre']) . '">' . htmlspecialchars($cocktail['titre']) . '</a><br>';
                            break; 
                        }
                    }
                }
                echo "</ul>";
            }
        }
    }
}
?>