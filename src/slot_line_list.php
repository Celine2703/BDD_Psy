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

    $stmt = $conn->prepare("SELECT s.start_date_slot, CASE WHEN tc.start_date_slot IS NOT NULL THEN 'Réservé' ELSE 'Disponible' END AS status FROM slot s LEFT JOIN to_consult tc ON s.start_date_slot = tc.start_date_slot ORDER BY s.start_date_slot");
    $stmt->execute();

    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($slots as $slot) {
        $start_date_time = new DateTime($slot['start_date_slot']);
        $end_date_time = clone $start_date_time;
        $end_date_time->modify('+30 minutes'); // chaque slot dure 30 min

        echo "<tr>";
        echo "<td>" . $start_date_time->format('d/m/Y') . "</td>"; // Affiche la date
        echo "<td>" . $start_date_time->format('H:i') . "</td>"; // Affiche l'heure de début
        echo "<td>" . $end_date_time->format('H:i') . "</td>"; // Affiche l'heure de fin
        echo "<td>" . $slot['status'] . "</td>"; // Affiche la disponibilité
        echo "</tr>";
    }
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
