<?php
session_start();

if ( isset($_SESSION['nav'])){
    $_SESSION['nav'] = $_GET['nav'];
} else {
    $_SESSION['nav'] = '';
}

?>