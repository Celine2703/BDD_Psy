<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdd_psy";

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
