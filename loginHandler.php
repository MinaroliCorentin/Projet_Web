<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        require_once "dbh.inc.php";

        // Get user from DB
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Utilisateur introuvable.");
        }

        // Verify password
        if (password_verify($password, $user["password"])) {

            // Créer une session 
            // A CHANGER 
            $_SESSION["userid"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: index.php");
            exit();

        } else {
            die("Mot de passe incorrect.");
        }

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }

} else {
    header("Location: login.php");
    exit();
}
