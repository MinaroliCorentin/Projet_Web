<?php
    require_once 'includes/config_session.inc.php';
    require_once 'includes/view.inc.php';
    include 'header.php';

    require_once 'includes/dbh.inc.php';
    require_once 'includes/model.inc.php';

    $user = get_user($pdo, $_SESSION['user_username']);
?>
<main>
    <div class = "middle">
        <h1>Page du compte de <?php echo $_SESSION["user_username"]; ?></h1>
        
        <form method="post" action="includes/modif.inc.php" class="connexion">
            Nom d'utilisateur :<br><input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"><br>
            Nom : <br><input type="text" name="nom" value="<?= htmlspecialchars($user['lastname']) ?>"><br>
            Prénom : <br><input type="text" name="prenom" value="<?= htmlspecialchars($user['firstname']) ?>"><br>
            Date de naissance : <br><input type="date" name="birth" value="<?= htmlspecialchars($user['birth']) ?>"><br>
            Adresse : <br><input type="text" name="adresse" value="<?= htmlspecialchars($user['address']) ?>"><br>
            Code Postal : <br><input type="text" name="codePostale" value="<?= htmlspecialchars($user['codePostal']) ?>"><br>
            Ville : <br><input type="text" name="ville" value="<?= htmlspecialchars($user['ville']) ?>"><br>
            Tel : <br><input type="text" name="tel" value="<?= htmlspecialchars($user['tel']) ?>"><br>
            Email : <br><input type="text" name="email" value="<?= htmlspecialchars($user['email']) ?>"><br>
            Mot de passe : <br><input type="password" name="pwd" value="<?= htmlspecialchars($user['password'])?>"><br>
            <br>
            <input type="submit" name="modif" value="Enregistrer les modifications" class="bouton">
        </form>

        <?php
            // Verification des informations transmises pour le connexion
            check_modif_errors();
        ?>


        <form method="post" action="includes/logout.inc.php">
            <button class="bouton2">Deconnexion</button>
        </form>
    </div>
</main>
    <?php include 'footer.php'; ?>
</body>
</html>