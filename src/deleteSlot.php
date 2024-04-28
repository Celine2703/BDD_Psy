<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<?php
include("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de l'identifiant du slot depuis le POST
    $slotId = $_POST['slotId'];

    // Vérifier si l'ID du slot a été fourni
    if (empty($slotId)) {
        throw new Exception("L'ID du slot n'a pas été spécifié.");
    }

    // Début de la transaction
    $conn->beginTransaction();

    // Suppression des consultations associées au slot
    $stmtConsult = $conn->prepare("DELETE FROM to_consult WHERE start_date_slot = :slotId");
    $stmtConsult->bindParam(':slotId', $slotId);
    $stmtConsult->execute();

    // Suppression du slot lui-même
    $stmtSlot = $conn->prepare("DELETE FROM slot WHERE start_date_slot = :slotId");
    $stmtSlot->bindParam(':slotId', $slotId);
    $stmtSlot->execute();

    // Valider la transaction
    $conn->commit();

    echo "Slot et consultations associées supprimées avec succès.";
    header("Location: ./slot");
    exit();
}
catch(PDOException $e) {
    // Annuler la transaction en cas d'erreur
    $conn->rollBack();
    echo "Erreur de base de données : " . $e->getMessage();
}
catch(Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
