<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $stmt = $conn->prepare("SELECT * FROM patient");
        $stmt->execute();

        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer les résultats de la requête SQL
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
// return $patients;

// Fermer la connexion à la base de données
$conn = null;
?>
