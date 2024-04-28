<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $conn->beginTransaction();

    // Mise à jour des informations modifiables du patient
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['security_number'])) {
        $security_number = $_POST['security_number'];
        $known_by = $_POST['known_by'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $stmt = $conn->prepare("UPDATE patient SET known_by = ?, email = ?, phone = ? WHERE security_number = ?");
        $stmt->execute([$known_by, $email, $phone, $security_number]);

        // Traitement des jobs ajoutés
        if (isset($_POST['job_names']) && isset($_POST['job_start_dates'])) {
            $job_names = $_POST['job_names'];
            $job_start_dates = $_POST['job_start_dates'];

            for ($i = 0; $i < count($job_names); $i++) {
                $stmt = $conn->prepare("INSERT INTO to_execute (security_number, name, start_date) VALUES (?, ?, ?)");
                $stmt->execute([$security_number, $job_names[$i], $job_start_dates[$i]]);
            }
        }

        if (isset($_POST['consultations_to_delete'])) {
            foreach ($_POST['consultations_to_delete'] as $consultation_id) {
                $stmt = $conn->prepare("DELETE FROM to_consult WHERE id = ?");
                $stmt->execute([$consultation_id]);
            }
        }

        $conn->commit();
        echo "Informations mises à jour avec succès.";
        header("Location: ./patient");
        exit();
    }
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Erreur lors de la mise à jour : " . $e->getMessage();
}
?>
