<?php

/*
    Fichier qui permet d'afficher le nom d'utilisateur
    mais également les erreurs lors du remplissage du formulaire
*/

// Force le typage des variables dans les paramètres fonctions
declare(strict_types=1);


// Fonction affiche les erreurs lors de l'inscription
function check_signup_errors(){
    if (isset($_SESSION['errors_signup'])){
        $errors = $_SESSION['errors_signup'];

        echo '<br>';

        foreach ($errors as $error){
            echo '<p class="erreur">' . $error . '</p>';
        }

        unset($_SESSION['errors_signup']);
    }else if (isset($_GET['signup']) && $_GET['signup'] === "success"){
        echo '<br>';
        echo '<p class="success">Succès de l\'inscription</p>';
    }
}


// Fonction qui affiche qui est connecter
function affiche_username(){
    if (isset($_SESSION['user_id'])){
        echo "You are logged in as " . $_SESSION["user_username"];
    }else{
        echo "you are not logged in";
    }
}


// Fonction qui affiche les erreurs lors de la connexion
function check_login_errors(){
    if(isset($_SESSION['errors_login'])){
        $errors = $_SESSION['errors_login'];
        echo '<br>';

        foreach ($errors as $error){
            echo '<p class="erreur">'.$error.'</p>';
        }
        unset($_SESSION['errors_login']);
    }
    else if (isset($_GET['login']) && $_GET['login'] === 'success'){
        echo '<br>';
        echo '<p class="success">Succès de la connexion</p>';
    }
}


//Fonction qui affiche les erreurs lors de l'ajout de la recette au favoris
function check_ajout(){
    if (isset($_SESSION['erreur_ajout'])){
        $errors = $_SESSION['erreur_ajout'];
        echo '<br>';
        foreach ($errors as $error){
            echo '<p class="erreur">'.$error.'</p>';
        }
        unset($_SESSION['erreur_ajout']);
    }
    else if (isset($_GET['ajout']) && $_GET['ajout'] === 'success'){
        echo '<br>';
        echo '<p class="success">Succès de l\'ajout !</p>';
    }
}



// Fonction affiche les erreurs lors de la modif du profil
function check_modif_errors(){
    if (isset($_SESSION['error_modif'])){
        $errors = $_SESSION['error_modif'];

        echo '<br>';

        foreach ($errors as $error){
            echo '<p class="erreur">' . $error . '</p>';
        }

        unset($_SESSION['error_modif']);
    }else if (isset($_GET['modif']) && $_GET['modif'] === "success"){
        echo '<br>';
        echo '<p class="success">Succès de la modification</p>';
    }
}