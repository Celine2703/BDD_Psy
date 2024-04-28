<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// Récupération des paramètres de tri et de filtre depuis la requête AJAX
$column = $_GET['column'] ?? 'formatted_date'; // Colonne par défaut pour le tri
$order = $_GET['order'] ?? 'ASC'; // Ordre de tri par défaut
$date_from = $_GET['date_from'] ?? ''; // Filtre de date de début
$date_to = $_GET['date_to'] ?? ''; // Filtre de date de fin
$status_filter = $_GET['status'] ?? ''; // Filtre de statut

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Construction de la clause WHERE pour les filtres
    $whereClauses = [];
    if (!empty($date_from) && !empty($date_to)) {
        $whereClauses[] = "DATE(start_date_slot) BETWEEN '$date_from' AND '$date_to'";
    }
    if (!empty($status_filter)) {
        if ($status_filter === 'Réservé') {
            $whereClauses[] = "EXISTS (SELECT * FROM to_consult WHERE start_date_slot = slot.start_date_slot)";
        } elseif ($status_filter === 'Disponible') {
            $whereClauses[] = "NOT EXISTS (SELECT * FROM to_consult WHERE start_date_slot = slot.start_date_slot)";
        }
    }

    // Assemblage des conditions de filtrage
    $whereSql = $whereClauses ? ' WHERE ' . implode(' AND ', $whereClauses) : '';

    // Préparation de la requête avec tri dynamique
    $query = "SELECT *, DATE_FORMAT(start_date_slot, '%Y-%m-%d') AS formatted_date,
              TIME_FORMAT(start_date_slot, '%H:%i') AS start_time,
              TIME_FORMAT(ADDTIME(start_date_slot, '00:30:00'), '%H:%i') AS end_time,
              (CASE 
                WHEN EXISTS (SELECT * FROM to_consult WHERE start_date_slot = slot.start_date_slot) THEN 'Réservé'
                ELSE 'Disponible'
              END) AS status
              FROM slot
              $whereSql
              ORDER BY $column $order";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($slots as $slot) {
        echo "<tr>";
        echo "<td style='width: 120px;'>" . htmlspecialchars($slot['formatted_date']) . "</td>";
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
