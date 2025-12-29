<?php
/*
    Fichier de connexion à la DB, utilser pour les requêtes SQL
*/

require_once 'install.php';

// Renseignement des informations autour de la DB
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    //Si server local
    $host = 'localhost';
    $dbname = 'projetWeb';
    $dbusername = 'root';
    $dbpassword = '';
}
else{
    //Pour site de prod
    $host = 'projeymroot.mysql.db';
    $dbname = 'projeymroot';
    $dbusername = 'projeymroot';
    $dbpassword = '86Nfo4uFOlXKy7IiH96R5jlv';
}

try{
    
    // Tentative de connexion
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e){
    
    // Affichage erreur
    die("Connection failed: " . $e->getMessage());
    
}