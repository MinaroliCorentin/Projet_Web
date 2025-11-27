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
            color: blue;
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
        <h3>Recettes</h3>
        <?php
            foreach ( $Recettes as $cocktail){
                echo "<li>" . htmlspecialchars($cocktail['titre']) . "</li>";
            }
        ?>
    </nav>

    <div class="resultats">
        <h2> Recherche pas ingrédients </h2>
        <input type="text" id="RechercheIngredient" placeholder="En cours" oninput="fonctionkeyup()">
        <div id="resultatsListe"></div>
    </div>
</div>

<script>

// Lance l'éxécution de la fonction dès le chargement
document.addEventListener("DOMContentLoaded", fonctionkeyup);

function fonctionkeyup() {

    const query = document.getElementById("RechercheIngredient").value.trim();

        fetch('fonctionPHP.php?rech=' + encodeURIComponent(query))
            .then(response => response.text())
            .then(html => {
                document.getElementById('resultatsListe').innerHTML = html;
            })
}
</script>


</script>

</div>

<footer>
    Projet Soirée Jeudi Soir 
</footer>

</body>
</html>
