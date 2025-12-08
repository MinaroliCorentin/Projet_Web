<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8" />
</head>

<body>

<h1>login</h1>

<form method="POST" action="loginHandler.php">
    <fieldset>
        Username:
        <input type="text" name="username" required /><br /><br>

        Password:
        <input type="password" name="password" required /><br /><br>
    </fieldset>

    <input type="submit" value="Valider" />
</form>

<h1>register</h1>

<form method="POST" action="registerHandler.php">
    <fieldset>
        Username:
        <input type="text" name="username" required /><br /><br>

        Password:
        <input type="password" name="password" required /><br /><br>
    </fieldset>

    <input type="submit" value="Valider" />
</form>

</body>
</html>
