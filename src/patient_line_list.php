<?php
function truncate($string, $length = 15) {
    if (strlen($string) > $length) {
        return htmlspecialchars(substr($string, 0, $length)) . "...";
    } else {
        return htmlspecialchars($string);
    }
}

if ($patients) {
    foreach ($patients as $patient) {
        echo "<tr>";
        echo "<td data-id='" . truncate($patient['security_number']) . "'>" . (!empty($patient['security_number']) ? truncate($patient['security_number']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['firstname']) ? truncate($patient['firstname']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['second_name']) ? truncate($patient['second_name']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['lastname']) ? truncate($patient['lastname']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['sex']) ? htmlspecialchars($patient['sex'] == 'f' ? "Féminin" : "Masculin") : '-') . "</td>";
        echo "<td>" . (!empty($patient['born_date']) ? htmlspecialchars($patient['born_date']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['email']) ? truncate($patient['email']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['phone']) ? truncate($patient['phone']) : '-') . "</td>";
        echo "<td>";
        echo '<a href="./patient-show?id=' .   truncate($patient['security_number']) . '" class="edit"><i class="material-icons" data-toggle="tooltip" title="Modifier">&#xE254;</i></a>';
        echo '<a href="#deleteEmployeeModal" class="delete btn-line" data-toggle="modal" data-toggle="tooltip" title="Supprimer" data-id="' . truncate($patient['security_number']) . '"> <i class="material-icons" >&#xE872;</i></a>';
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9' style='text-align: center;'>Aucun patient trouvé.</td></tr>";
}
?>
