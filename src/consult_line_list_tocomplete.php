<?php
if ($consults) {
    foreach ($consults as $consult) {
        $start_date_time = new DateTime($consult['start_date_slot']);
        $end_date_time = clone $start_date_time;
        $end_date_time->modify('+30 minutes');

        // Vérification si les champs sont complets sauf 'start_date_consult'
        $requiredFields = ['arrival_date_consult', 'price', 'payment_method', 'anxiety_index', 'observations', 'security_number'];
        $isComplete = true;

        foreach ($requiredFields as $field) {
            if (empty($consult[$field])) {
                $isComplete = false;
                break;
            }
        }

        echo "<tr>";
        echo "<td>" . $start_date_time->format('d/m/Y') . "</td>";
        echo "<td>" . $start_date_time->format('H:i') . "</td>";
        echo "<td>" . $end_date_time->format('H:i') . "</td>";
        echo "<td>" . $consult['security_number'] . "</td>";
        echo "<td>" . ($isComplete ? 'Terminé' : 'En attente') . "</td>";
        echo "<td class='text-center'>";
        echo '<div class="btn-group" role="group" aria-label="Basic example">';
        echo '<a href="#deleteEmployeeModal" class="btn consult delete" data-toggle="modal" data-id="' . $start_date_time->format('Y-m-d H:i:s') . '"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
        echo '<form action="consult-fill" method="post" style="display: inline-block;">';
        echo '<input type="hidden" name="start_date_slot" value="' . $start_date_time->format('Y-m-d H:i:s') . '">';
        echo '<input type="hidden" name="security_number" value="' . htmlspecialchars($consult['security_number']) . '">';
        echo '<button type="submit" class="btn consult"><i class="fa-solid fa-plus" title="Remplir"></i></button>';
        echo '</form>';
        echo '</div>';
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' style='text-align: center;'>Aucun slot trouvé.</td></tr>";
}
?>
