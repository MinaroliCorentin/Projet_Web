<?php

    /*
        Fichier qui sert à créer la base de donnée pour le site de développement
    */


    // Définition des informations de la connexion
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        $host = "localhost";
        $dbName = "projetWeb";
        $dbuser = "root";
        $dbpwd = "";

        try{
            // Connexion au SGBD
            $pdo = new PDO("mysql:host=$host", $dbuser, $dbpwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Création de la DB
            $sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";

            $pdo->exec($sql);

            $pdo->exec("USE `$dbName`;");
            
            //Creation de la table user
            $tableSql = "
                CREATE TABLE IF NOT EXISTS users (
                    id INT NOT NULL AUTO_INCREMENT,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    firstname VARCHAR(50) NULL,
                    lastname VARCHAR(50) NULL,
                    address VARCHAR(100) NULL,
                    codePostal INT(10) NULL,
                    ville VARCHAR(50) NULL,
                    birth DATE NULL,
                    tel VARCHAR (20) NULL,
                    email VARCHAR(100) NULL,
                    password VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id)
                );
            ";

            $pdo->exec($tableSql);


            //Creation de la table favoris
            $tableSql = "
                CREATE TABLE IF NOT EXISTS favoris (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    recette VARCHAR(255) NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                );

            ";

            $pdo->exec($tableSql);

        } catch (PDOException $e) {
            
            // Affichage erreur
            echo "Error creating database: " . $e->getMessage();

        }
    }
?>