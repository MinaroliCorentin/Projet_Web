<?php
include_once 'Donnees.inc.php';

if(isset($_GET['recette']) && $_GET['recette'] !== "") {
    $string = strtolower($_GET['recette']);
    
    foreach ( $Hierarchie as $aliment){
        echo "<li>" . htmlspecialchars($aliment) . "</li>";
    }

}

?>
