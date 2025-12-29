<?php

/*
    Fichier qui permet la vérification des information transmises
    dans les formulaires de connexion et d'inscription
*/


// Force l'utilisation des typages dans la déclaration des fonctions
declare(strict_types=1);

/*
    Fonction qui vérifie que le formulaire n'est pas vide à sa transmition
    AU niveau des champs requérit
*/
function form_vide(string $username, string $pwd){
    if( empty($username) || empty($pwd)){
        return true;
    }
    else{
        return false;
    }
}


// Vérification de la validité du format de l'email
function test_format_mail(string $email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else{
        return false;
    }
}


// Vérifie l'unicité de pseudo
function test_unique_username(object $pdo, string $username){
    if(get_username($pdo, $username)) {
        return true;
    }
    else{
        return false;
    }
}


// Vérifie l'unicité de l'email
function test_email_existant(object $pdo, string $email){
    if(get_email($pdo, $email)) {
        return true;
    }
    else{
        return false;
    }
}


// Création d'un utilisateur
function create_user(object $pdo, string $username, ?string $prenom, ?string $nom, ?string $adresse, ?string $codePostale, ?string $ville, ?string $birth, ?string $tel ,?string $email, string $pwd){
    set_user($pdo, $username, $prenom, $nom, $adresse, $codePostale, $ville, $birth, $tel, $email, $pwd);
}

// Création d'un utilisateur
function alter_user(object $pdo, int $id, string $username, ?string $prenom, ?string $nom, ?string $adresse, ?string $codePostale, ?string $ville, ?string $birth, ?string $tel ,?string $email, string $pwd){
    reset_user($pdo, $id, $username, $prenom, $nom, $adresse, $codePostale, $ville, $birth, $tel, $email, $pwd);
}


// fonction qui regarde si le login est correcte
function test_bad_login(bool|array $result){
    if(!$result){
        return true;
    }else{
        return false;
    }
}


// vérifie le mot de passe
function test_bad_password(string $pwd,string $hashedPwd){
    if ( !password_verify($pwd, $hashedPwd)){
        return true;
    }
    else{
        return false;
    }
}

//fonction qui teste si une recette est présente dans la session
function recette_presente(string $recette){
    $result = false;
    $recettes = $_SESSION['recettes'];
    foreach ($recettes as $r){
        if ($r === $recette){
            $result = true;
        }
    }
    return $result;
}


//Fonction qui teste la longueur des nom et prénoms
function test_len_nom(string $nom){
    if (!empty($nom) && strlen($nom) > 50){
        return true;
    }
    else{
        return false;
    }
}


//Fonction qui teste le format du mot de passe
function test_pwd(string $pwd){
    if (strlen($pwd) < 8){
        return true;
    }
    else{
        return false;
    }
}


//Fonction qui teste le format du nom/prenom
function test_format_nom(string $nom){
    if (!empty($nom) && !preg_match("/^[a-zA-ZÀ-ÿ '-]+$/u", $nom)){
        return true;
    }
    else{
        return false;
    }
}


//Fonction qui teste le format du code postale
function test_format_code_postale(string $codePostale){
    if (!empty($codePostale) && !preg_match('/^[0-9]{5}$/', $codePostale)){
        return true;
    }
    else{
        return false;
    }
}


//Fonction qui teste le format de la ville
function test_format_ville(string $ville){
    if (!empty($ville) && strlen($ville) > 50){
        return true;
    }
    else{
        return false;
    }
}


//Fonction qui teste le format de la date de naissance
function test_format_birth(string $birth){
    if (!empty($birth)){
        $d = DateTime::createFromFormat('Y-m-d', $birth);
        if (!$d || $d->format('Y-m-d') !== $birth) {
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}


//Fonction qui teste le format du tel
function test_format_tel(string $tel){
    if (!empty($tel)){
        // Supprime les espaces pour validation
        $tel_sanitized = str_replace(' ', '', $tel);

        // Vérifie que c'est un numéro français valide : commence par 0 et 10 chiffres
        if (!preg_match('/^0[1-9][0-9]{8}$/', $tel_sanitized)) {
           return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}