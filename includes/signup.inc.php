<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
    Fichier qui gère l'inscription au site
*/


/*
    Vérification de la provenance de la requête
    Si on vient d'ailleur que du formulaire c'est pas une action dite 'normal'
*/
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    
    // Définition des variables utilisateurs
    $username = $_POST['username'];
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $birth = $_POST['birth'] ?? null;
    $adresse = trim($_POST['adresse'] ?? '');
    $codePostale = trim($_POST['codePostale'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $tel = trim($_POST['tel'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pwd = $_POST['pwd'];
    
    try{
        //Inclusion des fichiers utile à l'inscription
        require_once 'config_session.inc.php';
        require_once 'dbh.inc.php';
        require_once 'model.inc.php';
        require_once 'contr.inc.php';


        //Gestion des erreurs
        $errors = [];


        // Vérification du remplissage des champs requièrit
        if( form_vide($username, $pwd)){
            $errors["empty_input"] = "Remplisser au moins le mot de passe et le nom d'utilisateur";
        }

        // Vérification du format de l'email
        if (!empty($email) && test_format_mail($email)){
            $errors["invalid_email"] = "Format de l'email invalid";
        }

        // Verification de l'unicité du nom d'utilisateur
        if (test_unique_username($pdo, $username)){
            $errors["username_taken"] = "Nom d'utilisateur déjà pris";
        }

        // Verification de l'unicité de l'email
        if (!empty($email) && test_email_existant($pdo, $email)){
            $errors["email_used"] = "Email already registered";
        }
    
        //Vérification de la longueur du pwd
        if (test_pwd($pwd)) {
            $errors["len_pwd"] = "Le mot de passe doit faire au moins 8 caractères.";
        }

        //Vérification de la longueur du nom
        if (test_len_nom($nom)){
            $errors["len_nom"] = "Le nom est trop long (max 50 caractères).";
        }
        //Vérification de la longueur du prenom
        if (test_len_nom($prenom)){
            $errors["len_prenom"] = "Le prénom est trop long (max 50 caractères).";
        }

        // Vérifier le format des caractères pour nom/prénom
        if (test_format_nom($nom)) {
            $errors["invalid_format_nom"] = "Le nom contient des caractères invalides.";
        }
        if (test_format_nom($prenom)) {
            $errors["invalid_format_prenom"] = "Le prénom contient des caractères invalides.";
        }

        //Vérification du format du Code postal
        if (test_format_code_postale($codePostale)) {
            $errors["invalid_format_code_postale"] = "Code postal invalide.";
        }

        //Vérification du format de la Ville
        if (test_format_ville($ville)){ $errors["invalid_format_ville"] = "Le nom de la ville est trop long.";}

        // Vérification du format de la Date de naissance
        if (test_format_birth($birth)){
            $errors["invalid_format_date"] = "Date de naissance invalide.";
        }

        //Vérification du format du Numéro de tel
        if (test_format_tel($tel)) {
            $errors["invalid_format_tel"] = "Numéro de téléphone invalide. Il doit contenir 10 chiffres et commencer par 0.";
        }
        

        
        // S'il y a des erreurs, ont les affiche et on annule l'inscription
        if ($errors){
            $_SESSION['errors_signup'] = $errors;
            header("Location: ../Formulaire.php");
            die();
        }

        // Création de l'utilisateur
        create_user($pdo, $username, $prenom, $nom, $adresse, $codePostale, $ville, $birth, $tel, $email, $pwd);

        

        // Redirection vers l'acceuil
        header("Location: ../Formulaire.php?signup=success");

        $pdo = null;
        $stmt = null;

        die();
    } catch (PDOException $e){
        // Affichage d'une erreur coté serveur dans l'inscrition
        die("Querry failedd : " . $e->getMessage());
    }
}
// SI la demande ne provient pas d'une action normal, redirection vers l'acceuil
else{
    header("Location: ../index.php");
}