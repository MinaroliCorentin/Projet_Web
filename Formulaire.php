
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <title>Projet Recettes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
        }
        header {
            background: #4CAF50;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            font-weight: bold;
            font-size: 20px;
        }
        .menu-centre button {
            margin: 0 5px;
            padding: 8px 12px;
            border: none;
            background: #fff;
            cursor: pointer;
        }
        .menu-centre {
            flex: 1;
            text-align: center;
        }
        .spacer {
            width: 40px;
        }
        .contenu {
            display: flex;
            width: 1000px;
            margin: 20px auto;
            margin-bottom: 10px;

        }
        nav {
            width: 200px;
            background: white;
            padding: 10px;
            border: 1px solid #ccc;
        }
        nav li {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
        }
        nav input {
            padding: 5px;
            margin-bottom: 30px; 
        }
        nav p {
            padding: 5px ; 
            font-size: 10px ;
        }
        .resultats {
            flex: 1;
            background: white;
            padding: 15px;
            border: 1px solid #ccc;
            margin-left: 15px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">LOGO</div>
    <div class="menu-centre">
        <button>Mes recettes préfères</button>
        <button>Action 2</button>
        <button>Action 3</button>
        <button>Action 4</button>
    </div>
    <div class="connection"> Connexion </div>
    <div class="spacer"></div>
</header>

<form method="post" action="registerHandler.php">
    <fieldset>
        <legend>S'inscrire</legend>
        Nom d'utilisateur : <input type="text" name="username" required><br><br>
        Nom : <input type="text" name="nom"><br><br>
        Prénom : <input type="text" name="prenom"><br><br>
        Date de naissance : <input type="date" name="birth"><br><br>
        Adresse : <input type="text" name="adresse"><br><br>
        Code Postal : <input type="text" phpname="codePostale"><br><br>
        Ville : <input type="text" name="ville"><br><br>
        Email : <input type="text" name="ville"><br><br>
        Mot de passe : <input type="password" name="password" required /><br /><br>
    </fieldset>
    <br>
    <input type="submit" name="connexion" value="Valider">
</form>

<br>
<br>
<br>

<form method="post" action="loginHandler.php">
    <fieldset>
        <legend>Se connecter</legend>
        Nom d'utilisateur : <input type="text" name="username" required><br><br>
        Mot de passe : <input type="password" name="password" required /><br /><br>
    </fieldset>
    <br>
    <input type="submit" name="connexion" value="Valider">
</form>


<footer>
    Projet Soirée Jeudi Soir 
</footer>
</body>


</html>