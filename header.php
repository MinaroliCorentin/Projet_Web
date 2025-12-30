<?php
include_once 'includes/Donnees.inc.php';
include_once 'includes/config_session.inc.php';

if (isset($_POST["connexion"])) {
    if( isset($_SESSION['user_username'])){
        header("Location: compte.php");
        exit();
    }
    else{
        header("Location: Formulaire.php");
        exit();
    }
}

if (isset($_SESSION["user_username"])){
    $nom = "Bonjour, ".$_SESSION["user_username"]." !";
}
else{
    $nom = "Connexion";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Projet Recettes</title>
    <link rel="stylesheet" href="couleur.css">
    <!-- CSS pour les icones du footer --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
    <div>
        <form method="post" action="index.php">
            <button type="submit" name="logo" class="special">LOGO</button>
        </form>
    </div>
    <div class="menu-centre">
        <form method="post" action="recette_fav.php">
            <button type="submit" name="favoris" class="special2">Mes recettes préfères</button>
        </form>
    </div>
    <div class="connection"> 
        <form method="post">
            <button type="submit" name="connexion" class="special2"><?php echo $nom ?></button>
        </form>
    </div>
    <div class="spacer"></div>
</header>