<?php
// Récupération de la session
session_start();

// Vidage de cette dernière
session_unset();

// Destruction de la session
session_destroy();

// Rédirection vers l'acceuil
header("Location: ../index.php");
die();