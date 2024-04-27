<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM to_consult ORDER BY start_date_slot ASC");
    $stmt->execute();
    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $events = [];

    foreach ($slots as $slot) {
        $start = new DateTime($slot['start_date_slot']);
        $end = clone $start;
        $end->modify('+30 minutes');  // Définir la durée de chaque slot à 30 minutes

        // Ajouter chaque slot comme un événement distinct
        $events[] = [
            'start' => $start->format('c'),  // Format ISO8601 pour la compatibilité avec FullCalendar
            'end' => $end->format('c'),
            'title' => 'Patient :' .  $slot['security_number']
        ];
    }

    echo json_encode($events);  // Envoyer les données au format JSON pour FullCalendar
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
