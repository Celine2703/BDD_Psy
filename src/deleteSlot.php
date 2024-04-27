<?php
include("loadEnv.php");

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Supposons que l'identifiant du slot est envoyé sous le nom 'slotId'.
    $slotId = $_POST['slotId'];

    // Vérifiez que l'ID du slot a été transmis et n'est pas vide
    if (empty($slotId)) {
        throw new Exception("L'ID du slot n'a pas été spécifié.");
    }

    $stmt = $conn->prepare("DELETE FROM slot WHERE start_date_slot = :slotId");
    $stmt->bindParam(':slotId', $slotId);
    $stmt->execute();

    echo "Slot supprimé avec succès.";
}
catch(PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
catch(Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
