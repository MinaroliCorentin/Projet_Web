<?php
include_once 'Donnees.inc.php'; 


?> 

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <title>Projet Recettes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
        }
        header {
            background: #4CAF50;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            font-weight: bold;
            font-size: 20px;
        }
        .menu-centre button {
            margin: 0 5px;
            padding: 8px 12px;
            border: none;
            background: #fff;
            cursor: pointer;
        }
        .menu-centre {
            flex: 1;
            text-align: center;
        }
        .spacer {
            width: 40px;
        }
        .contenu {
            display: flex;
            width: 1000px;
            margin: 20px auto;
            margin-bottom: 10px;

        }
        nav {
            width: 200px;
            background: white;
            padding: 10px;
            border: 1px solid #ccc;
        }
        nav li {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
        }
        nav input {
            padding: 5px;
            margin-bottom: 30px; 
        }
        .resultats {
            flex: 1;
            background: white;
            padding: 15px;
            border: 1px solid #ccc;
            margin-left: 15px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">LOGO</div>
    <div class="menu-centre">
        <button>Action 1</button>
        <button>Action 2</button>
        <button>Action 3</button>
        <button>Action 4</button>
    </div>
    <div class="spacer"></div>
</header>

<div class="contenu">
<nav>
    <h3>Sous-catégories de Aliment</h3>
    <ul>
    <?php
    if (isset($Hierarchie) && is_array($Hierarchie)) {

        echo "<p id='path'>Aliment</p>";

        $sousCategories = $Hierarchie['Aliment']['sous-categorie'];

        foreach ($sousCategories as $sousCat) {
            echo "<li><a href='index.php?recette=" . urlencode($sousCat) . "'>". htmlspecialchars($sousCat). "</a></li>";
        }
    }
    ?>
    <?php
    if (isset($_GET['recette']) && $_GET['recette'] !== "") {

        $recette = $_GET['recette'];
        echo "<h3>Résultats pour : " . htmlspecialchars($recette) . "</h3>";

        $recetteMin = strtolower($recette);

        foreach ($Hierarchie as $categorie => $info) {

            if (strtolower($categorie) === $recetteMin) {

                if (isset($info['sous-categorie'])) {
                    echo "<ul>";
                    foreach ($info['sous-categorie'] as $element) {
                        echo "<li><a href='index.php?recette=" . urlencode($element) . "'>". htmlspecialchars($element). "</a></li>";
                    }
                    echo "</ul>";
                }
            }
        }
    }
    ?>
    </ul>
</nav>



    <div class="resultats">
        <h2> Recherche pas ingrédients </h2>
        <input type="text" id="RechercheIngredient" placeholder="En cours" onkeyup="fonctionkeyup()">
        <div id="resultatsListe"></div>
    </div>
</div>

<script>

// Lance l'éxécution de la fonction dès le chargement
document.addEventListener("DOMContentLoaded", fonctionkeyup);

function fonctionkeyup() {

    const query = document.getElementById("RechercheIngredient").value.trim();

        // Appel de la fonction "rechercheIngredient" avec get = "rech" 
        fetch('rechercheIngredient.php?rech=' + encodeURIComponent(query))
            .then(response => response.text())
            .then(html => {
                document.getElementById('resultatsListe').innerHTML = html;
            })
}
</script>

</div>

<footer>
    Projet Soirée Jeudi Soir 
</footer>
</body>


</html>

