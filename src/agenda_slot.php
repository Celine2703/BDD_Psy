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

    $stmt = $conn->prepare("SELECT start_date_slot FROM slot ORDER BY start_date_slot ASC");
    $stmt->execute();
    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $events = [];
    $last_end_time = null;
    $event_start = null;

    foreach ($slots as $slot) {
        $start = new DateTime($slot['start_date_slot']);
        $end = clone $start;
        $end->modify('+30 minutes');

        if ($event_start === null) {
            // Start a new event
            $event_start = $start;
            $last_end_time = $end;
        } else {
            if ($start == $last_end_time) {
                // Extend the current event
                $last_end_time = $end;
            } else {
                // Save the current event and start a new one
                $events[] = [
                    'start' => $event_start->format('c'),
                    'end' => $last_end_time->format('c'),
                    'title' => 'Disponible'
                ];
                $event_start = $start;
                $last_end_time = $end;
            }
        }
    }

    // Don't forget to add the last event
    if ($event_start !== null) {
        $events[] = [
            'start' => $event_start->format('c'),
            'end' => $last_end_time->format('c'),
            'title' => 'Disponible'
        ];
    }

    echo json_encode($events);
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
