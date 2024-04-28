<?php
session_start();
include_once("loadEnv.php");
loadEnv();

$errors = [];
$_SESSION['errors'] = '';
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

        // Convertir la date de début en objet DateTime pour isoler la date sans l'heure
        $dateOnly = (new DateTime($start_date_slot))->format('Y-m-d');

        // Compter les consultations pour ce patient à cette date
        $stmt = $conn->prepare("SELECT COUNT(*) FROM to_consult WHERE security_number = ? AND DATE(start_date_slot) = ?");
        $stmt->execute([$security_number_main, $dateOnly]);
        $consultationCount = $stmt->fetchColumn();

        if ($consultationCount >= 3) {
            $errors['start_date_slot'] = "Vous avez déjà 3 consultations planifiées pour cette date.";
        }

        if (isset($_POST['patient_security_number'])) {
            foreach ($_POST['patient_security_number'] as $sec_num) {
                $stmt = $conn->prepare("SELECT COUNT(*) FROM to_consult WHERE security_number = ? AND DATE(start_date_slot) = ?");
                $stmt->execute([$sec_num, $dateOnly]);
                $consultationCount = $stmt->fetchColumn();
                if ($consultationCount >= 3) {
                    $errors['start_date_slot'] = "Un des patient a déjà 3 consultations planifiées pour cette date.";
                }
            }
        }

        $stmt = $conn->prepare("SELECT COUNT(*) FROM to_consult WHERE start_date_slot = ?");
        $stmt->execute([$start_date_slot]);
        if ($stmt->fetchColumn() >= 3) {
            $errors['start_date_slot'] = "Ce créneau est déjà complet.";
        }



        $_SESSION['errors'] = $errors;
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO to_consult (start_date_slot, security_number) VALUES (?, ?)");
            $stmt->execute([$start_date_slot, $security_number_main]);

            foreach ($_POST['patient_security_number'] as $sec_num) {
                $stmt->execute([$start_date_slot, $sec_num]);
            }

            $conn->commit();
            header("Location: my-consult");
            exit();
        } else {
            $conn->rollBack();
            header("Location: consult-create?eventStartDate=" . $_POST['start_date_slot']);
            exit();
        }
    } catch (PDOException $e) {
        echo  "Erreur de base de données : " . $e->getMessage();;
        $conn->rollBack();
        $errors['db_error'] = "Erreur de base de données : " . $e->getMessage();
        $_SESSION['errors'] = $errors;

    }
}
?>
