<?php include 'header.php'; ?>
<html>
<body>

<div class="contenu">
    <nav>
            <!-- Partie Recherche par ingredient nav -->  
        <div class="resultats">
            <?php
            if (isset($_SESSION["nav"]) && $_SESSION["nav"] !== "") {

                $recette = $_SESSION["nav"];

                echo "<p class=\"test\">" . $_SESSION['Historique'] . "</p>";
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
                                    echo '<a href="Recette.php?ingredient=' . urlencode($cocktail['titre']) . '" class="cocktail" data-nom="' . htmlspecialchars($cocktail['titre']) . '">' . htmlspecialchars($cocktail['titre']) . '</a><br>';                                    break; 
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
            <div id="preview"></div>

            <form method="GET">
                <input type="submit" name="reset" value="Réinitialiser">
            </form>
                <?php if (isset($_GET['reset'])){
                    $_SESSION["nav"] = 'Aliment'; 
                }
            ?> 
        </div>
    </nav>
    
    <!-- Partie Recherche par recette -->  
    <div class="resultats">
        <h2> Recherche pas ingrédients </h2>
        <input type="text" id="RechercheIngredient" onkeyup="fonctionkeyup()" placeholder="Eau">
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
        
        // Préchargement de l'image pour tester son existence
        const img = new Image();
        img.src = "Photos/" + nom;

        img.onload = () => {
            // L'image existe
            preview.innerHTML = "";
            preview.appendChild(img);
        };

        img.onerror = () => {
            // L'image n'existe pas
            preview.innerHTML = "<p>Image not found.</p>";
        };

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

<?php include 'footer.php'; ?>
</body>

</html>
