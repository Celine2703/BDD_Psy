<?php
include_once("loadEnv.php");
loadEnv();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Connexion à la base de données des patients
    echo $_GET['id'];
    $connData = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $connData->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recherche de l'email du patient
    $stmtData = $connData->prepare("SELECT email FROM patient WHERE security_number = ?");
    $stmtData->bindParam(1, $_GET['id']);
    $stmtData->execute();
    $email = $stmtData->fetchColumn();

    if (!$email) {
        echo "Email non trouvé pour le numéro de sécurité.";
        exit;
    }

    // Connexion à la base de données des utilisateurs
    $connUser = new PDO("mysql:host=" . $_ENV['DB_C_HOST'] . ";dbname=" . $_ENV['DB_C_NAME'], $_ENV['DB_C_USER'], $_ENV['DB_C_PASS']);
    $connUser->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Générer un mot de passe aléatoire
    $password = bin2hex(random_bytes(4)); // Génère un mot de passe aléatoire de 8 caractères
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertion de l'utilisateur
    $stmtUser = $connUser->prepare("INSERT INTO users (security_number, password, role) VALUES (?, ?, 'user')");
    $stmtUser->execute([$_GET['id'], $passwordHash]);

    // Envoi d'email
    mail($email, "Invitation à vous connecter", "Votre identifiant : " . $_GET['id'] . "\nVotre mot de passe : " . $password);

    echo "Invitation envoyée avec succès.";
}
?>
