<?php
require_once 'config_session.inc.php';

/*
    Vérification de la provenance de la requête
    Si on vient d'ailleur que du formulaire c'est pas une action dite 'normal'
*/
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $recette = $_POST['recette'];

    if (($key = array_search($recette, $_SESSION['recettes'])) !== false) {
        unset($_SESSION['recettes'][$key]);
    }

    // réindexation des clés
    $_SESSION['recettes'] = array_values($_SESSION['recettes']);

    if (sizeof($_SESSION['recettes']) == 0){
        unset($_SESSION['recettes']);
    }

    //Supression dans la DB
    if (isset($_SESSION['user_username'])){
        try{
            require_once 'dbh.inc.php';
            require_once 'model.inc.php';

            delete_recette($pdo, $_SESSION['user_username'], $recette);
        }
        catch( PDOException $e){
            // Affichage d'une erreur coté serveur dans l'ajout au favoris
            die("Querry failedd : " . $e->getMessage());
        }
    }
    

    header("location: ../recette_fav.php");
}
else{
    header("Location: ../index.php");
}