<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<?php
// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Effacement de toutes les variables de session
$_SESSION = array();

// Destruction de la session
session_destroy();

// Redirection vers la page de connexion ou la page d'accueil
header("Location: ../accueil");
exit();
?>