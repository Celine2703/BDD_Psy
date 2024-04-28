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
        echo "<td style='width: 120px;'>" . $start_date_time->format('d/m/Y') . "</td>";
        echo "<td>" . $start_date_time->format('H:i') . "</td>";
        echo "<td>" . $end_date_time->format('H:i') . "</td>";
        echo "<td>" . $slot['status'] . "</td>";
        echo "<td>";
        echo '<a href="#deleteEmployeeModal" class="delete btn-line" data-toggle="modal" data-id="' . $start_date_time->format('Y-m-d H:i:s') . '"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
        echo "</td>";
        echo "</tr>";
    }
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
