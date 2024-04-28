<?php
include_once("loadEnv.php");
loadEnv();

function truncate($string, $length = 15) {
    if (strlen($string) > $length) {
        return htmlspecialchars(substr($string, 0, $length)) . "...";
    } else {
        return htmlspecialchars($string);
    }
}

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$column = $_GET['column'] ?? 'security_number'; // Colonne par défaut pour le tri
$order = $_GET['order'] ?? 'ASC'; // Ordre de tri par défaut

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM patient ORDER BY $column $order");
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($patients as $patient) {
        echo "<tr>";
        echo "<td data-id='" . truncate($patient['security_number']) . "'>" . truncate(htmlspecialchars($patient['security_number'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['firstname'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['second_name'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['lastname'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['sex'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['born_date'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['email']) ). "</td>";
        echo "<td>" .  truncate(htmlspecialchars($patient['phone'])) . "</td>";
        echo "<td>";
        echo '<a href="./patient-show?id=' .   truncate($patient['security_number']) . '" class="edit"><i class="material-icons" data-toggle="tooltip" title="Modifier">&#xE254;</i></a>';
        echo '<a href="#deleteEmployeeModal" class="delete btn-line" data-toggle="modal" data-toggle="tooltip" title="Supprimer" data-id="' . truncate($patient['security_number']) . '"> <i class="material-icons" >&#xE872;</i></a>';
        echo "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
