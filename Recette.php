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

            foreach ($Recettes as $value){
                if ( $ingredient === $value['titre'] ){
                    echo "<strong>Ingrédients :</strong><br><br>";
                    $ingre_preparation = str_replace('|', '<br>', htmlspecialchars($value['ingredients']));
                    echo $ingre_preparation;     
                    echo "<br><br><strong>Préparation :</strong><br><br>";    
                    // Ajoute br à la fin 
                    echo nl2br(htmlspecialchars($value['preparation'])); 
                }
            }

            // Normalisation + .jpg
            $ingredientjpg = Normalizer::normalize($ingredient, Normalizer::FORM_D);
            $ingredientjpg = preg_replace('/\p{M}/u', '', $ingredientjpg);
            $ingredientjpg = str_replace(' ', '_', ucfirst(strtolower($ingredientjpg))) . ".jpg";
            $ingredientjpg = str_replace('-', '', $ingredientjpg);
            $ingredientjpg = str_replace('\'', '', $ingredientjpg);

            

            echo "IMAGE " . $ingredientjpg ; 

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