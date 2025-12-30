<?php
    require_once 'includes/config_session.inc.php';
    // contient Donnees.inc.php
    include 'header.php'; 
?>
<!DOCTYPE html>
<html>
<body>

<div class="contenu">
    <nav>
        <div class="resultats">
            <?php 
                // L'inclusion ici pour garantir affiche correct 
                include 'nav_logic.php'; 
            ?>

            <div id="preview"></div>

            <form method="GET">
                <input type="submit" name="reset" value="Réinitialiser">
            </form>
        </div>
    </nav>
    
    <div class="resultats">
        <h2> Recherche par ingrédients </h2>
        <legend> Entrez les ingrédients séparés par des virgules (utilisez ! pour exclure).</legend>
        <input type="text" id="RechercheIngredient" onkeyup="fonctionkeyup()" placeholder="citron,!glaçon">
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
        // Remplace les - et les ' par des "" 
        nom = nom.replace(/['-]/g, "");
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
            // Bien garder le string vide sinon ca part en 🥜
            preview.innerHTML = ""; 
            preview.appendChild(img);
        };

        img.onerror = () => {
            // L'image n'existe pas : on affiche quand même le nom tenté
            preview.innerHTML = "<p>Image non trouvée pour : <strong>" + nom + "</strong></p>"; 
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