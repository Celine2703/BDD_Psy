<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $start_date_slot = $_POST['start_date_slot'];
    $security_number = $_SESSION['user'];

    if (empty($start_date_slot) || empty($security_number)) {
        throw new Exception("Les données nécessaires pour la suppression ne sont pas complètes.");
    }

    $stmt = $conn->prepare("DELETE FROM to_consult WHERE start_date_slot = :start_date_slot AND security_number = :security_number");
    $stmt->bindParam(':start_date_slot', $start_date_slot);
    $stmt->bindParam(':security_number', $security_number);
    $stmt->execute();

    echo "Consultation supprimée avec succès.";
    header("Location: ./my-consult");
    exit();
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
