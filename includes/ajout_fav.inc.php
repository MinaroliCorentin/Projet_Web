<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['recette'])) {
        $recette = $_POST['recette'];
    } else {
        header("Location: ../index.php");
    }

    //Gestion des erreurs
    require_once 'contr.inc.php';
    require_once 'config_session.inc.php';

    if (!isset($_SESSION['recettes'])){
        $_SESSION['recettes'] = [$recette];

        if(isset($_SESSION['user_username'])){//On est connecter
            ajout_db($recette);
        }

        header('Location: ../' . $_SESSION['retrun_uri'].'&ajout=success');
    }
    else if (recette_presente($recette)){
        $_SESSION['erreur_ajout'] = ['Ajout impossible, la recette est déjà dans vos favoris'];
        header('Location: ../' . $_SESSION['retrun_uri']);
    }
    else{
        $_SESSION['recettes'][] = $recette;

        if(isset($_SESSION['user_username'])){//On est connecter
            ajout_db($recette);
        }

        header('Location: ../' . $_SESSION['retrun_uri'].'&ajout=success');
    }

}
else{
    header("Location: ../index.php");
}


function ajout_db($r){
    $recette = $r;
    try{
        //Inclusion des fichiers utile à l'inscription
        require_once 'dbh.inc.php';
        require_once 'model.inc.php';

        set_fav($pdo, $_SESSION['user_username'], $recette);

        $pdo = null;
        $stmt = null;

    }catch (PDOException $e){
        // Affichage d'une erreur coté serveur dans l'ajout au favoris
        die("Querry failedd : " . $e->getMessage());
    }
}