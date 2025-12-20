<?php
include_once 'Donnees.inc.php'; 

session_start();

// Recherche Dans le nav 
if (isset($_GET['nav'])) {
    if( $_SESSION['nav'] != $_GET['nav'] ){
        $_SESSION['Historique'] = $_SESSION['Historique'] . "/" . $_SESSION['nav'] ; 
    }
    $_SESSION['nav'] = $_GET['nav'];
}

// Bouton Reset
if (isset($_GET['reset'])) {
    $_SESSION["nav"] = 'Aliment';
    $_SESSION['Historique'] = ''; 
}


if (isset($_POST["connexion"])) {
    header("Location: Formulaire.php");
    exit();
}

if (isset($_POST["logo"])) {
    header("Location: index.php");
    exit();
}


?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Projet Recettes</title>
    <link rel="stylesheet" href="couleur.css">
</head>
<body>

<header>
    <div>
        <form method="post">
            <button type="submit" name="logo" class="special">LOGO</button>
        </form>
    </div>
    <div class="menu-centre">
        <button>Mes recettes préfères</button>
        <button>Action 2</button>
        <button>Action 3</button>
        <button>Action 4</button>
    </div>
    <div class="connection"> 
        <form method="post">
            <button type="submit" name="connexion" class="special">Connexion</button>
        </form>
    </div>
    <div class="spacer"></div>
</header>