<?php
include_once 'includes/Donnees.inc.php';
require_once 'includes/view.inc.php';  
require_once 'includes/config_session.inc.php';
include 'header.php';
?>

<main class="contenu">
    <section class="resultats">
        
        <?php
        if(isset($_GET['ingredient']) && $_GET['ingredient'] !== "") {
            $ingredient = $_GET['ingredient'];
            
            $name = htmlspecialchars($ingredient);
            
            echo "<h1>" . $name . "</h1>";

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

        <div class="fav">
            <?php
                $params = [
                    'ingredient' => $_GET['ingredient'],   // string ou array → OK
                ];

                $url = 'Recette.php?' . http_build_query($params);

                $_SESSION['retrun_uri'] = $url;
            ?>

            <form method="post" action="includes/ajout_fav.inc.php">
                <input type="hidden" name="recette" value="<?= htmlspecialchars($name) ?>">
                
                <button id="favoris" class="bouton">Ajouter aux favoris</button>
            </form>

            <?php
                check_ajout();
            ?>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>