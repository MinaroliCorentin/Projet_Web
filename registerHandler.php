<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        require_once "dbh.inc.php";

        // Verif user
        $checkQuery = "SELECT username FROM users WHERE username = :username LIMIT 1;";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(":username", $username);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            die("Ce nom d'utilisateur existe déjà.");
        }

        // Hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Mise dans DB
        $query = "INSERT INTO users (username, password) VALUES (:username, :password);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de l'inscription : " . $e->getMessage());
    }

} else {
    header("Location: login.php");
    exit();
}
