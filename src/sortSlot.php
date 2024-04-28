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

// Paramètres de tri et de filtre récupérés de la requête
$column = $_GET['column'] ?? 'security_number'; // Colonne par défaut pour le tri
$order = $_GET['order'] ?? 'ASC'; // Ordre de tri par défaut
$ageFilter = $_GET['age'] ?? ''; // Filtre pour l'âge
$sexFilter = $_GET['sex'] ?? ''; // Filtre pour le sexe
$searchTerm = $_GET['search'] ?? ''; // Terme de recherche

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Construction de la requête avec filtres et tri
    $query = "SELECT * FROM patient WHERE 1=1 ";

    if (!empty($sexFilter)) {
        $query .= "AND sex = :sex ";
    }

    if (!empty($ageFilter)) {
        $currentYear = date('Y');
        if ($ageFilter === '0-12') {
            $query .= "AND YEAR(born_date) >= ($currentYear - 12) ";
        } elseif ($ageFilter === '12-18') {
            $query .= "AND YEAR(born_date) BETWEEN ($currentYear - 18) AND ($currentYear - 12) ";
        } elseif ($ageFilter === '18+') {
            $query .= "AND YEAR(born_date) < ($currentYear - 18) ";
        }
    }

    if (!empty($searchTerm)) {
        $query .= "AND (security_number LIKE :search OR firstname LIKE :search OR second_name LIKE :search OR lastname LIKE :search OR email LIKE :search OR phone LIKE :search) ";
    }

    $query .= "ORDER BY $column $order";

    $stmt = $conn->prepare($query);

    // Liaison des paramètres pour le sexe et la recherche
    if (!empty($sexFilter)) {
        $stmt->bindParam(':sex', $sexFilter);
    }

    if (!empty($searchTerm)) {
        $searchWildcard = '%' . $searchTerm . '%';
        $stmt->bindParam(':search', $searchWildcard);
    }

    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($patients as $patient) {
        echo "<tr>";
        echo "<td>" . truncate(htmlspecialchars($patient['security_number'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['firstname'])) . "</td>";
        echo "<td>" . (!empty($patient['second_name']) ? truncate($patient['second_name']) : '-') . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['lastname'])) . "</td>";
        echo "<td>" . (!empty($patient['sex']) ? htmlspecialchars($patient['sex'] == 'f' ? "Féminin" : "Masculin") : '-') . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['born_date'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['email'])) . "</td>";
        echo "<td>" . truncate(htmlspecialchars($patient['phone'])) . "</td>";
        echo "<td>";
        echo '<a href="./patient-show?id=' .   truncate($patient['security_number']) . '" class="edit"><i class="material-icons" data-toggle="tooltip" title="Modifier">&#xE254;</i></a>';
        echo '<a href="#deleteEmployeeModal" class="slot delete btn-line" data-toggle="modal" data-toggle="tooltip" title="Supprimer" data-id="' . truncate($patient['security_number']) . '"> <i class="material-icons" >&#xE872;</i></a>';
        echo "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}