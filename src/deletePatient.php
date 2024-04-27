<?php
include("loadEnv.php");

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try
{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $patientId = $_POST['patientId'];

    $stmt = $conn->prepare("DELETE FROM patient WHERE security_number = :patientId");
    $stmt->bindParam(':patientId', $patientId);
    $stmt->execute();

    echo "Patient supprimé.";
}
catch(PDOException $e)
{
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
