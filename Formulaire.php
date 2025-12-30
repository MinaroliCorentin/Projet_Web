<?php 
    require_once 'includes/config_session.inc.php';
    require_once 'includes/view.inc.php';
    include 'header.php';
?>
<main>
    <div class="formulaire">
        <div class="connexion">

            <?php
                // Verification des informations transmises pour l'inscription
                check_signup_errors();
            ?>

            <form method="post" action="includes/signup.inc.php">
                <h1>Inscription</h1>
                Nom d'utilisateur :<br><input type="text" name="username" placeholder="JeanDu55"><br>
                Nom : <br><input type="text" name="nom" placeholder="Dupont"><br>
                Prénom : <br><input type="text" name="prenom" placeholder="Jean"><br>
                Date de naissance : <br><input type="date" name="birth"><br>
                Adresse : <br><input type="text" name="adresse" placeholder="17 Rue du General de Gaulle"><br>
                Code Postal : <br><input type="text" name="codePostale" placeholder="55000"><br>
                Ville : <br><input type="text" name="ville" placeholder="Bar-le-Duc"><br>
                Tel : <br><input type="text" name="tel" placeholder="0783091928"><br>
                Email : <br><input type="text" name="email" placeholder="dupont@mailer.tv"><br>
                Mot de passe : <br><input type="password" name="pwd" placeholder="pwd"><br>
                <br>
                <input type="submit" name="connexion" value="S'inscrire" class="bouton">
            </form>


        </div>


        <div class="connexion">
            <?php
                // Verification des informations transmises pour le connexion
                check_login_errors();
            ?>
            <form method="post" action="includes/login.inc.php">
                <h1>Connexion</h1>
                Nom d'utilisateur :<br><input type="text" name="username"><br>
                Mot de passe :<br><input type="password" name="pwd"><br>
                <br>
                <input type="submit" name="connexion" value="Se connecter" class="bouton">
            </form>
            

        </div>


    </div>
</main>
    <?php include 'footer.php'; ?>
</body>
</html>