<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        require_once "dbh.inc.php";

        /* --- 1. Check if username already exists --- */
        $checkQuery = "SELECT username FROM users WHERE username = :username LIMIT 1;";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(":username", $username);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            die("Ce nom d'utilisateur existe déjà.");
        }

        /* --- 2. Hash password --- */
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        /* --- 3. Insert new user --- */
        $query = "INSERT INTO users (username, password) VALUES (:username, :password);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();

        /* --- 4. Clean up and redirect --- */
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
