<?php
if ($slots)
{
    foreach ($slots as $slot)
    {
        // Supposons que la date de début contient à la fois la date et l'heure
        $start_date_time = new DateTime($slot['start_date_slot']);
        $end_date_time = clone $start_date_time;
        $end_date_time->modify('+30 minutes'); // chaque slot dure 30 min

        echo "<tr>";
        echo "<td>" . $start_date_time->format('d/m/Y') . "</td>"; // Affiche la date
        echo "<td>" . $start_date_time->format('H:i') . "</td>"; // Affiche l'heure de début
        echo "<td>" . $end_date_time->format('H:i') . "</td>"; // Affiche l'heure de fin
        echo "<td>Disponible</td>"; // Affiche la disponibilité, à adapter selon la logique métier
        echo "<td>";
        echo '<a href="#deleteEmployeeModal" class="delete btn-line" data-toggle="modal" data-id="' . $start_date_time->format('Y-m-d H:i:s') . '"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
        echo "</td>";
        echo "</tr>";
    }
}
else
{
    echo "<tr><td colspan='5' style='text-align: center;'>Aucun slot trouvé.</td></tr>";
}
?>
