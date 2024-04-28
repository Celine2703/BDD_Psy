<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// Récupération des paramètres de tri depuis la requête AJAX
$column = $_GET['column'] ?? 'formatted_date'; // Colonne par défaut pour le tri
$order = $_GET['order'] ?? 'ASC'; // Ordre de tri par défaut

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête avec tri dynamique
    $query = "SELECT *, DATE_FORMAT(start_date_slot, '%Y-%m-%d') AS formatted_date,
              TIME_FORMAT(start_date_slot, '%H:%i') AS start_time,
              TIME_FORMAT(ADDTIME(start_date_slot, '00:30:00'), '%H:%i') AS end_time,
              (CASE 
                WHEN EXISTS (SELECT * FROM to_consult WHERE start_date_slot = slot.start_date_slot) THEN 'Programmé'
                ELSE 'Disponible'
              END) AS status
              FROM slot
              ORDER BY $column $order";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($slots as $slot) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($slot['formatted_date']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['start_time']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['end_time']) . "</td>";
        echo "<td>" . htmlspecialchars($slot['status']) . "</td>";
        echo "<td><a href='#deleteEmployeeModal' class='delete btn-line' data-toggle='modal' data-id='" . htmlspecialchars($slot['start_date_slot']) . "'><i class='material-icons' data-toggle='tooltip' title='Delete'>&#xE872;</i></a></td>";
        echo "</tr>";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
