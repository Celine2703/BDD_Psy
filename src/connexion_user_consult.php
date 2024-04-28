<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<?php
session_start();

include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['user'])) {
        throw new Exception("Utilisateur non identifié.");
    }

    $securityNumber = $_SESSION['user'];

    $stmt = $conn->prepare("SELECT * FROM to_consult WHERE security_number = :security_number");
    $stmt->bindParam(':security_number', $securityNumber);
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
