<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['security_number'])) {
        $security_number = $_POST['security_number'];
        $known_by = $_POST['known_by'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Mise à jour des infos du patient
        $stmt = $conn->prepare("UPDATE patient SET known_by = ?, email = ?, phone = ? WHERE security_number = ?");
        $stmt->execute([$known_by, $email, $phone, $security_number]);

        // Gestion des jobs
        if (isset($_POST['job_names']) && isset($_POST['job_start_dates']) && isset($_POST['job_end_dates'])) {
            $job_names = $_POST['job_names'];
            $job_start_dates = $_POST['job_start_dates'];
            $job_end_dates = $_POST['job_end_dates'];

            for ($i = 0; $i < count($job_names); $i++) {

                if ( empty($job_names[$i]) || empty($job_start_dates[$i]) || empty($job_end_dates[$i]) ) {
                    continue ;
                }
                // Vérifiez d'abord si le job existe déjà dans la table `job`
                $job_check_stmt = $conn->prepare("SELECT COUNT(*) FROM job WHERE name = ?");
                $job_check_stmt->execute([$job_names[$i]]);
                $job_exists = $job_check_stmt->fetchColumn() > 0;

                // Si le job n'existe pas, créez-le
                if (!$job_exists) {
                    $job_insert_stmt = $conn->prepare("INSERT INTO job (name) VALUES (?)");
                    $job_insert_stmt->execute([$job_names[$i]]);
                }

                // Insérer dans to_execute
                $execute_insert_stmt = $conn->prepare("INSERT INTO to_execute (security_number, name, start_date, end_date) VALUES (?, ?, ?, ?)");
                $execute_insert_stmt->execute([$security_number, $job_names[$i], $job_start_dates[$i], $job_end_dates[$i]]);
            }
        }

        $conn->commit();
        header("Location: ./patient");
        exit();
    }
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Erreur lors de la mise à jour : " . $e->getMessage();
}
?>
