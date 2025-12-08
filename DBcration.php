<?php

$host = "localhost";
$dbName = "testdb";
$user = "root";
$pwd = "";

try {
    // Connexion
    $pdo = new PDO("mysql:host=$host", $user, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Création de la DB
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

    $pdo->exec($sql);


    //Creation de la table user
    $tableSql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            firstname VARCHAR(50),
            lastname VARCHAR(50),
            address VARCHAR(50),
            codePostal INT(5);
            ville VARCHAR(50),
            birth DATE NOT NULL,
            tel INT (10),
            email VARCHAR(100),
            password VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
        );
    ";

    $pdo->exec($tableSql);


    //Creation de la table ...
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}
?>

