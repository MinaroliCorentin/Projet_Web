<?php 

    include 'header.php'; 
    require_once 'includes/config_session.inc.php';

?>



<main>
    <div>
        <?php
            if (isset($_SESSION['recettes'])){
                $recettes = $_SESSION['recettes'];
                foreach($recettes as $recette){
                    echo '<div class="favoris">';
                    echo '<a href="Recette.php?ingredient=' . urlencode($recette) . '">' . $recette . '</a>';
                    echo '<form method="post" class="" action="includes/remove.inc.php">';
                    echo '<input type="hidden" name="recette" value="' . htmlspecialchars($recette) . '">';
                    echo '<button class="bouton">supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            else{
                echo '<div class="favoris">';
                echo '<p>Vous n\'avez rien dans vos favori</p>';
                echo '</div>';
            }
        ?>
    </div>
</main>
    <?php include 'footer.php'; ?>
</body>
</html>