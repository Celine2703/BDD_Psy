<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$column = $_GET['column'] ?? 'start_date_slot';  // Colonne par défaut pour le tri
$order = $_GET['order'] ?? 'ASC';                // Ordre de tri par défaut

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT *, 
          (CASE 
            WHEN arrival_date_consult IS NOT NULL AND price IS NOT NULL AND payment_method IS NOT NULL AND anxiety_index IS NOT NULL AND observations IS NOT NULL THEN 'Complet' 
            ELSE 'À compléter' 
          END) AS status 
          FROM to_consult 
          WHERE start_date_slot <= NOW()
          ORDER BY $column $order";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $consults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($consults as $consult) {
        $start_date_time = new DateTime($consult['start_date_slot']);
        $end_date_time = clone $start_date_time;
        $end_date_time->modify('+30 minutes');

        echo "<tr>";
        echo "<td>" . $start_date_time->format('d/m/Y') . "</td>";
        echo "<td>" . $start_date_time->format('H:i') . "</td>";
        echo "<td>" . $end_date_time->format('H:i') . "</td>";
        echo "<td>" . $consult['security_number'] . "</td>";
        echo "<td>" . $consult['status'] . "</td>";
        echo "<td class='text-center'>";
        echo '<div class="btn-group" role="group" aria-label="Basic example">';
        echo '<form action="consult-fill" method="post" style="display: inline-block;">';
        echo '<input type="hidden" name="start_date_slot" value="' . $start_date_time->format('Y-m-d H:i:s') . '">';
        echo '<input type="hidden" name="security_number" value="' . htmlspecialchars($consult['security_number']) . '">';
        echo '<button type="submit" class="btn consult"><i class="fa-solid fa-plus" title="Remplir"></i></button>';
        echo '</form>';
        echo '</div>';
        echo "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
