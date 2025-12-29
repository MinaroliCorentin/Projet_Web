<?php

declare(strict_types=1);

// Fonction qui récupère toutes les info d'un utilisateur
function get_user(object $pdo, string $username){
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


//Fonction qui cherche un nom d'utilisateur
function get_username(object $pdo, string $username){
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


// Fonction qui cherche un email
function get_email(object $pdo, string $email){
    $query = "SELECT username FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


// Fonction qui créer un utilisateur
function set_user(object $pdo, string $username, ?string $prenom, ?string $nom, ?string $adresse, ?string $codePostale, ?string $ville, ?string $birth, ?string $tel ,?string $email, string $pwd){
    $query = "INSERT INTO users 
    (username, firstname, lastname, address, codePostal, ville, birth, tel, email, password)
    VALUES (:username, :firstname, :lastname, :address, :codePostal, :ville, :birth, :tel, :email, :pwd);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    //tentative de correction de bug
    $firstname  = $prenom;
    $lastname   = $nom;
    $address    = $adresse;
    if (empty($codePostale)){
        $cp = null;
    }
    else{
        $cp = (int)$codePostale;
    }
    $city       = $ville;
    $birthdate = null;
    if (!empty($birth)) {
        $d = DateTime::createFromFormat('Y-m-d', $birth);
        if ($d && $d->format('Y-m-d') === $birth) {
            $birthdate = $birth;
        }
    }
    $phone      = $tel;
    $mail       = $email;

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':codePostal', $cp);
    $stmt->bindValue(':ville', $city);
    $stmt->bindValue(':birth', $birthdate);
    $stmt->bindValue(':tel', $phone);
    $stmt->bindValue(':email', $mail);
    $stmt->bindValue(':pwd', $hashedPwd);

    $stmt->execute();
}


//Fonction qui récupère l'ID d'un user
function get_id(object $pdo, string $username){
    $query = "SELECT id FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    return $result;
}

//Fonction qui ajoute une recette dans les favoris
function set_fav(object $pdo, string $username, string $recette){
    $id = get_id($pdo, $username);

    $query = "INSERT INTO favoris (user_id, recette) VALUES (:id, :recette);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":recette", $recette);
    $stmt->execute();
}


//fonction qui renvoie tous les recettes favorites d'un utilisateurs
function get_all_fav(object $pdo, string $username){
    $id = get_id($pdo, $username);

    $query = "SELECT recette FROM favoris WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $result;
}


//fonction qui récupère une rectte parmis les favoris d'un utilisateur
function get_recette(object $pdo, string $username, string $recette){
    $id = get_id($pdo, $username);

    $query = "SELECT recette FROM favoris WHERE user_id = :id AND recette = :recette";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":recette", $recette);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


//fonction qui supprime des favoris une recette chez un utilisateur
function delete_recette(object $pdo, string $username, string $recette){
    $id = get_id($pdo, $username);

    $query = "DELETE FROM favoris WHERE user_id = :id AND recette = :recette";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":recette", $recette);
    $stmt->execute();
}


// Fonction qui altère un utilisateur
function reset_user(object $pdo, int $id, string $username, ?string $prenom, ?string $nom, ?string $adresse, ?string $codePostale, ?string $ville, ?string $birth, ?string $tel ,?string $email, string $pwd){
    $query = "UPDATE users SET
        username = :username,
        firstname = :firstname,
        lastname = :lastname,
        address = :address,
        codePostal = :codePostal,
        ville = :ville,
        birth = :birth,
        tel = :tel,
        email = :email,
        password = :pwd
        WHERE id = :id;";
    
    $stmt = $pdo->prepare($query);

    // Hash du mot de passe
    $options = ['cost' => 12];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    // Préparation des valeurs
    $firstname  = $prenom;
    $lastname   = $nom;
    $address    = $adresse;
    $cp         = empty($codePostale) ? null : (int)$codePostale;
    $city       = $ville;

    $birthdate = null;
    if (!empty($birth)) {
        $d = DateTime::createFromFormat('Y-m-d', $birth);
        if ($d && $d->format('Y-m-d') === $birth) {
            $birthdate = $birth;
        }
    }

    $phone = $tel;
    $mail  = $email;

    // Liaison des paramètres
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':codePostal', $cp);
    $stmt->bindValue(':ville', $city);
    $stmt->bindValue(':birth', $birthdate);
    $stmt->bindValue(':tel', $phone);
    $stmt->bindValue(':email', $mail);
    $stmt->bindValue(':pwd', $hashedPwd);

    $stmt->execute();
}