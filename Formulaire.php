<?php include 'header.php'; ?>
<main>
    <div class="formulaire">
        <form method="post" action="registerHandler.php" class="connexion">
            <h1>Inscription</h1>
            Nom d'utilisateur :<br><input type="text" name="username" placeholder="JeanDu55" required><br>
            Nom : <br><input type="text" name="nom" placeholder="Dupont"><br>
            Prénom : <br><input type="text" name="prenom" placeholder="Jean"><br>
            Date de naissance : <br><input type="date" name="birth"><br>
            Adresse : <br><input type="text" name="adresse" placeholder="17 Rue du General de Gaulle"><br>
            Code Postal : <br><input type="text" phpname="codePostale" placeholder="55000"><br>
            Ville : <br><input type="text" name="ville" placeholder="Bar-le-Duc"><br>
            Email : <br><input type="text" name="ville" placeholder="dupont@mailer.tv"><br>
            Mot de passe : <br><input type="password" name="password" placeholder="Mot de passe Fort" required /><br />
            <br>
            <input type="submit" name="connexion" value="S'inscrire">
        </form>

        <form method="post" action="loginHandler.php" class="connexion">
            <h1>Connexion</h1>
            Nom d'utilisateur :<br><input type="text" name="username" required><br>
            Mot de passe :<br><input type="password" name="password" required /><br />
            <br>
            <input type="submit" name="connexion" value="Se connecter">
        </form>
    </div>
</main>
    <?php include 'footer.php'; ?>
</body>
</html>