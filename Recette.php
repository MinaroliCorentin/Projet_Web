<?php
include_once 'Donnees.inc.php';
include 'header.php'; ?>

<html>
<body>
<?php
echo "<table border='1'>"; 
echo "<tr> ";
echo "<td> ";

if(isset($_GET['ingredient']) && $_GET['ingredient'] !== "") {

    $ingredient = $_GET['ingredient'];

    $ingredientjpg = $_GET['ingredient'];

    echo "<h1>" . $ingredient . "</h1>" ; 

    echo $ingredientjpg . "<br>" ; 

    $ingredientjpg = preg_replace('/(\s)/i','_',$ingredientjpg);
    echo $ingredientjpg . "<br>" ; 

    $ingredientjpg = strtolower($ingredientjpg);

    echo $ingredientjpg . "<br>" ; 

    $ingredientjpg = ucfirst($ingredientjpg);

    echo $ingredientjpg . "<br>" ; 

    // 1. On sépare les accents des lettres (Normalisation NFD)
    $ingredientjpg = Normalizer::normalize($ingredientjpg, Normalizer::FORM_D);
    // 2. On supprime les caractères de type "M" (Marks/Accents)
    $ingredientjpg = preg_replace('/\p{M}/u', '', $ingredientjpg);

    echo $ingredientjpg . "<br>" ; 

    $ingredientjpg = $ingredientjpg . ".jpg" ; 

    echo $ingredientjpg . "<br>" ; 

    if (file_exists("Photos/".$ingredientjpg)) {
        echo '<img src="Photos/'.$ingredientjpg.'">';
    } else {
        echo "FIle non trouvé";
    }
}

// J'ai mis cela dans le php pour eviter le cas ou le get marche pas -> Comportement incertain 
echo "</td>";  
echo "</tr>";
echo "<tr>" ;
echo "<p> dsdsdds </p>" ;
echo "</tr>" ;
echo "</table>" ;

echo "<div>";
echo "<button id =\"favoris\">Ajouter aux favories</button>";
echo"</div>" 

?>

<?php include 'footer.php'; ?>
</body> 

</html> 
