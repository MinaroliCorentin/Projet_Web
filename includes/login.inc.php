<?php

/*
    Fichier qui gère la  connexion au site
*/


/*
    Vérification de la provenance de la requête
    Si on vient d'ailleur que du formulaire c'est pas une action dite 'normal'
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try{
        //Inclusion des fichiers utile
        require_once 'dbh.inc.php';
        require_once 'model.inc.php';
        require_once 'contr.inc.php';


        // Gestion des erreurs
        $errors = [];


        // Verification que tous les champs requièrit sont remplis
        if (form_vide($username, $pwd)){
            $errors['empty_input'] = 'Remplissez tous les champs!';
        }

        // Prises des infos de l'utilisateur pour de prochaines vérifs
        $result = get_user($pdo, $username);

        //Vérifications du login
        if (test_bad_login($result)){
            $errors['login_incorrect'] = 'Le login est incorrecte!';
        }

        // Vérifications du mot de passe
        if (!test_bad_login($result) && test_bad_password($pwd, $result['password'])){
            $errors['login_incorrect'] = 'Le mot de passe est incorrecte!';
        }

        //inclusions du fichiers de sessions
        require_once 'config_session.inc.php';

        // S'il y a des erreurs -> annulation de la connexion
        if ($errors){
            $_SESSION['errors_login'] = $errors;

            header("Location: ../Formulaire.php");
            die();
        }



        //sync des favoris
        $recettesDB = get_all_fav($pdo, $username);
        $recetteSession = $_SESSION['recettes'];
        
        //1 - ajout de la session dans la DB
        if (!isset($_SESSION['recettes']) || !is_array($_SESSION['recettes'])) {
            $recetteSession = [];
        }
        if (count($recetteSession) > 0) {
            foreach( $recetteSession as $r){
                if(!get_recette($pdo, $username, $r)){
                    set_fav($pdo, $username, $r);
                }
            }
        }

        //2 - ajout de la db dans la session
        foreach($recettesDB as $r){
            if(!in_array($r, $recetteSession)){
                if (!isset($_SESSION['recettes'])){
                    $_SESSION['recettes'] = [$r];
                }
                else{
                    $_SESSION['recettes'][] = $r;
                }
            }
        }
        
        // Mis à jour de la session
        session_connect($result);

        // Redirection vers l'acceuil
        header("Location: ../index.php?login=success");
        
        $pdo = null;
        $stmt = null;
        
        die();
    }catch ( PDOException $e){
        // Affichage des erreurs de serveur
        die("Querry failed".$e->getMessage());
    }
}else{
    // Si la requête n'est pas normal redirection vers l'acceuil
    header("Location: ../index.php");
    die();
}