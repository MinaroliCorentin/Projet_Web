<?php
session_start();
include 'donnees.inc.php'; // ton tableau $Rubriques

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connexion'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $_SESSION['user'] = $nom;  // créer la session
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vos données</title>
    <meta charset="utf-8" />
    <style>
        a:link { color: green; text-decoration: none; }
    </style>
</head>
<body>

<h1>Epicerie du coin d'la rue</h1>
<p>1 rue du Bois</p>
<p>54000 Nancy</p>

<table border="1" width="100%">
<tr>
    <!-- Gauche -->
    <td width="150">
        <strong>Rubriques</strong><br><br>
        <a href="index.php?page=fruits">Fruits<br></a>
        <a href="index.php?page=legumes">Legumes<br></a>
        <a href="index.php?page=divers">Divers<br></a>
        <a href="index.php?page=facturation">Facturation</a>
    </td>

    <!-- Droite -->
    <td id="zoneFormulaire" style="background:gray; padding:20px;">
    <?php

    // Sinon, afficher la rubrique choisie
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch($page) {
            case 'fruits':
            case 'legumes':
            case 'divers':
                include 'fruits.php';
                break;
            case 'facturation':
                include 'facturation.php';
                break;
            default:
                echo "Page non trouvée";
        }
    } else {
        echo "Bienvenue " . htmlspecialchars($_SESSION['user']) . "! Sélectionnez une rubrique à gauche.";
    }
    ?>
    </td>
</tr>
</table>

</body>
</html>
