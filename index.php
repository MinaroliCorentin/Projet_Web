<?php
include_once 'Donnees.inc.php'; 

session_start();

// Recherche Dans le nav 
if (isset($_GET['nav'])) {
    $_SESSION['nav'] = $_GET['nav'];
    $_SESSION['Historique'] = $_SESSION['Historique'] . "/" . $_SESSION['nav'] ; 
}

// Bouton Reset
if (isset($_GET['reset'])) {
    $_SESSION["nav"] = 'Aliment';
    $_SESSION['Historique'] = 'Aliment'; 
}

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
        nav p {
            padding: 5px ; 
            font-size: 10px ;
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

    <?php
    if (isset($_SESSION["nav"]) && $_SESSION["nav"] !== "") {

        $recette = $_SESSION["nav"];

        echo "<p>" . $_SESSION['Historique'] . "</p>";
        echo "<h3>Résultats pour : " . htmlspecialchars($recette) . "</h3>";

        $recetteMin = strtolower($recette);

        foreach ($Hierarchie as $categorie => $info) {

            // Cherche du bon nom 
            if (strtolower($categorie) === $recetteMin) {

                // Recherche des keys de la l'association avec les elements
                if (isset($info['sous-categorie'])) {

                    echo "<ul>";
                    foreach ($info['sous-categorie'] as $element) {
                        echo '<li><a href="index.php?nav=' . $element . '">' . htmlspecialchars($element) . '</a></li>';
                    }
                    echo "</ul>";
                } else {
                // Si le isset ne renvoie rien ( pas de sous-categorie )
                echo "<ul>";
                foreach($Recettes as $cocktail) {
                    foreach($cocktail['index'] as $ingredient) {
                        // Utilisatoin de strcasecmp et non de strcmp car ingredient est un tableau, pas un string isolé
                        if (strcasecmp(strtolower($ingredient), $categorie) === 0) {
                            echo "<a href='#' class='cocktail' data-nom='" . htmlspecialchars($cocktail['titre']) . "'>". htmlspecialchars($cocktail['titre']) ."</a><br>";
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

    <!-- Div id pour les images  -->
    <div id="preview" style="margin-top:10px;"></div>

    <form method="GET">
        <input type="submit" name="reset" value="Réinitialiser">
    </form>
        <?php if (isset($_GET['reset'])){
            $_SESSION["nav"] = 'Aliment'; 
        }
    ?> 

</nav>
    <div class="resultats">
        <h2> Recherche pas ingrédients </h2>
        <input type="text" id="RechercheIngredient" onkeyup="fonctionkeyup()">
        <div id="resultatsListe"></div>
    </div>
</div>

<script> 

document.querySelectorAll(".cocktail").forEach(item => {
    item.addEventListener("mouseenter", () => {
        // Recupère le nom 
        let nom = item.dataset.nom;
        // Retire les accents 
        nom = nom.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        // Retire les espaces 
        nom = nom.replace(/ /g, "_");

        // Met en minuscule
        nom = nom.toLowerCase();  
        
        // Met la première lettre en majuscule
        tmp = nom.charAt(0).toUpperCase()
        
        // Fusion de la premiere lettre en majuscule et de nom sans la premiere lettre. 
        // P + ina colada
        nom = tmp + nom.slice(1)

        // Ajoute .jpg
        nom = nom.concat(".jpg") ; 

        preview.innerHTML = "<img src='Photos/" + nom + "'>";

    });
});

</script> 

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


<footer>
    Projet Soirée Jeudi Soir 
</footer>
</body>


</html>
