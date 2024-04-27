<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_C_HOST'];
$username = $_ENV['DB_C_USER'];
$password = $_ENV['DB_C_PASS'];
$dbname = $_ENV['DB_C_NAME'];

header('Content-Type: application/json');

try {
    $conn1 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['security_number']) && isset($_POST['password'])) {
        $secu_number = $_POST['security_number'];
        $password = $_POST['password'];

        $stmt = $conn1->prepare("SELECT password, role FROM users WHERE security_number = ?");
        $stmt->bindParam(1, $secu_number);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $password_hash = stripslashes($result['password']);
            if (password_verify($password, $password_hash)) {
                $_SESSION['user_role'] = $result['role'];
                $_SESSION['user'] = $secu_number;
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Identifiants incorrects']);
            }
        } else {
            echo json_encode(['error' => 'Utilisateur non trouvé']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
}

$conn1 = null;
?>
