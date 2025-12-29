<?php

/*
    Fichier qui gère la modification d'un utilisateur
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


        $user = get_user($pdo, $_SESSION['user_username']);

        $options = [
            'cost' => 12
        ];
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);


        //Gestion des erreurs
        $errors = [];

        // Vérification du format de l'email
        if ($email != $user['email'] && !empty($email) && test_format_mail($email)){
            $errors["invalid_email"] = "Format de l'email invalid";
        }

        // Verification de l'unicité du nom d'utilisateur
        if ($username != $user['username'] && test_unique_username($pdo, $username)){
            $errors["username_taken"] = "Nom d'utilisateur déjà pris";
        }

        // Verification de l'unicité de l'email
        if ($email != $user['email'] && !empty($email) && test_email_existant($pdo, $email)){
            $errors["email_used"] = "Email déjà renseingé";
        }
    
        //Vérification de la longueur du pwd
        if ($hashedPwd != $user['password'] && test_pwd($pwd)) {
            $errors["len_pwd"] = "Le mot de passe doit faire au moins 8 caractères.";
        }

        //Vérification de la longueur du nom
        if ($nom != $user['lastname'] && test_len_nom($nom)){
            $errors["len_nom"] = "Le nom est trop long (max 50 caractères).";
        }
        //Vérification de la longueur du prenom
        if ($prenom != $user['firstname'] && test_len_nom($prenom)){
            $errors["len_prenom"] = "Le prénom est trop long (max 50 caractères).";
        }

        // Vérifier le format des caractères pour nom/prénom
        if ($nom != $user['lastname'] && test_format_nom($nom)) {
            $errors["invalid_format_nom"] = "Le nom contient des caractères invalides.";
        }
        if ($prenom != $user['firstname'] && test_format_nom($prenom)) {
            $errors["invalid_format_prenom"] = "Le prénom contient des caractères invalides.";
        }

        //Vérification du format du Code postal
        if ($codePostale != $user['usecodePostalrname'] && test_format_code_postale($codePostale)) {
            $errors["invalid_format_code_postale"] = "Code postal invalide.";
        }

        //Vérification du format de la Ville
        if ($ville != $user['ville'] && test_format_ville($ville)){ $errors["invalid_format_ville"] = "Le nom de la ville est trop long.";}

        // Vérification du format de la Date de naissance
        if ($birth != $user['birth'] && test_format_birth($birth)){
            $errors["invalid_format_date"] = "Date de naissance invalide.";
        }

        //Vérification du format du Numéro de tel
        if ($tel != $user['tel'] && test_format_tel($tel)) {
            $errors["invalid_format_tel"] = "Numéro de téléphone invalide. Il doit contenir 10 chiffres et commencer par 0.";
        }
        

        
        // S'il y a des erreurs, ont les affiche et on annule l'inscription
        if ($errors){
            $_SESSION['error_modif'] = $errors;
            header("Location: ../compte.php");
            die();
        }

       
        // Création de l'utilisateur
        alter_user($pdo, $user['id'], $username, $prenom, $nom, $adresse, $codePostale, $ville, $birth, $tel, $email, $pwd);

        
        //Mise à jour de la session
        maj_session($username);

        // Redirection vers l'acceuil
        header("Location: ../compte.php?modif=success");

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