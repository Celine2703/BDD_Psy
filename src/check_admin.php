<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 // Assurez-vous que la session est démarrée
// Vérifie si l'utilisateur est connecté et si c'est un admin
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
if (!$is_admin) {
    header("Location: ./accueil");
    exit();
}
?>
