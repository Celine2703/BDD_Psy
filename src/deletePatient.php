<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<?php
include("loadEnv.php");

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $patientId = $_POST['patientId'];

    $stmtConsult = $conn->prepare("DELETE FROM to_consult WHERE security_number = :patientId AND start_date_slot > NOW()");
    $stmtConsult->bindParam(':patientId', $patientId);
    $stmtConsult->execute();

    $stmt = $conn->prepare("DELETE FROM patient WHERE security_number = :patientId");
    $stmt->bindParam(':patientId', $patientId);
    $stmt->execute();

    echo "Patient et ses consultations futures supprimées.";
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
