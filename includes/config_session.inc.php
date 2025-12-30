<?php

/*
    Fichier qui vise à sécuriser les sessions, de base pas trop sécuriser
    Sources pour son écriture : internet
*/


ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    session_set_cookie_params([
        'lifetime' => 0,
        'domain' => 'localhost',
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict'

    ]);
}
else{
    session_set_cookie_params([
        'lifetime' => 0,
        'domain' => '',
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'

    ]);
}

//Début de la séssion
session_start();
$_SESSION["nav"] = 'Aliment';
$_SESSION['Historique'] = ''; 

/*
    Définition de la régénération de la session
    elle doit changer assez fréquement pour éviter d'être trop vulnérable
*/
if (!isset($_SESSION['last_regeneration'])) { // Si la session n'a jamais était regérer on le fait
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else { // Sinon on définit une intervalle de régénération

    $interval = 60 * 30; // 30 min

    if (time() - $_SESSION['last_regeneration'] > $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}


// Regénération de l'ID à la connexion de l'utilisateur, question de sécurité
function session_connect($result){
    session_regenerate_id(true);
    $_SESSION['user_id'] = $result['id'];
    $_SESSION['user_username'] = htmlspecialchars($result['username']);
    $_SESSION['last_regeneration'] = time();
}



//Mise à jour à la modif
function maj_session($username){
    $_SESSION['user_username'] = htmlspecialchars($username);
    $_SESSION['last_regeneration'] = time();
}