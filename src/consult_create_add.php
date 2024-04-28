<?php
session_start();
include_once("loadEnv.php");
loadEnv();

$errors = []; // Initialisation du tableau d'erreurs

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $start_date_slot = $_POST['start_date_slot'];
    $security_number_main = $_SESSION['user'];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM to_consult WHERE start_date_slot = ?");
        $stmt->execute([$start_date_slot]);
        if ($stmt->fetchColumn() >= 3) {
            $errors['start_date_slot'] = "Ce créneau est déjà complet.";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO to_consult (start_date_slot, security_number) VALUES (?, ?)");
            $stmt->execute([$start_date_slot, $security_number_main]);

            foreach ($_POST['patient_security_numbers'] as $sec_num) {
                $stmt->execute([$start_date_slot, $sec_num]);
            }

            $conn->commit();
            header("Location: my-consult");
            exit();
        } else {
            $conn->rollBack();
        }
    } catch (PDOException $e) {
        echo  "Erreur de base de données : " . $e->getMessage();;
        $conn->rollBack();
        $errors['db_error'] = "Erreur de base de données : " . $e->getMessage();
    }
}
?>
