<?php
include_once 'Donnees.inc.php';
include 'header.php';
?>

<main class="contenu">
    <section class="resultats">
        
        <?php
        if(isset($_GET['ingredient']) && $_GET['ingredient'] !== "") {
            $ingredient = $_GET['ingredient'];
            
            echo "<h1>" . htmlspecialchars($ingredient) . "</h1>";

        foreach ($Recettes as $value) {
            if ($ingredient === $value['titre']) {
                echo "<strong>Ingrédients :</strong><br><br>";
                
                // Affichage des ingrédients
                echo "<ul><li>"; 
                $ingre = htmlspecialchars($value['ingredients']);
                echo str_replace('|', '</li><li>', $ingre);
                echo "</li></ul>";

                echo "<br><strong>Préparation :</strong><br><br>";
                
                $prep = htmlspecialchars($value['preparation']);
                $prep = rtrim($prep, '. '); 

                echo "<ul><li>";
                echo str_replace('.', '</li><li>', $prep);
                echo "</li></ul>";
            }
        }

            // Normalisation + .jpg
            $ingredientjpg = Normalizer::normalize($ingredient, Normalizer::FORM_D);
            $ingredientjpg = preg_replace('/\p{M}/u', '', $ingredientjpg);
            $ingredientjpg = str_replace(' ', '_', ucfirst(strtolower($ingredientjpg))) . ".jpg";
            $ingredientjpg = str_replace('-', '', $ingredientjpg);
            $ingredientjpg = str_replace('\'', '', $ingredientjpg);

            if (file_exists("Photos/".$ingredientjpg)) {
                echo '<div id="preview"><img src="Photos/'.$ingredientjpg.'" alt="Photo"></div>';
            }
        }
        ?>

        <div style="margin-top: 20px;">
            <button id="favoris">Ajouter aux favoris</button>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>