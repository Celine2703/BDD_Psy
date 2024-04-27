<?php
session_start(); // Assurez-vous de démarrer la session avant d'accéder à $_SESSION

include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Assurez-vous que l'utilisateur est connecté et que le numéro de sécurité sociale est disponible
    if (!isset($_SESSION['user'])) {
        throw new Exception("Utilisateur non identifié.");
    }

    $securityNumber = $_SESSION['user'];  // Récupérer le numéro de sécurité sociale depuis la session

    $stmt = $conn->prepare("SELECT * FROM to_consult WHERE security_number = :security_number");
    $stmt->bindParam(':security_number', $securityNumber);  // Lie le paramètre à la requête
    $stmt->execute();

    $consults = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
catch(PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}
catch(Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
