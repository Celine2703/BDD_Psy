<?php
if ($patients)
{
    foreach ($patients as $patient)
    {
        echo "<tr>";
        echo "<td data-id='" . htmlspecialchars($patient['security_number']) . "'>" . (!empty($patient['security_number']) ? htmlspecialchars($patient['security_number']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['firstname']) ? htmlspecialchars($patient['firstname']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['second_name']) ? htmlspecialchars($patient['second_name']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['lastname']) ? htmlspecialchars($patient['lastname']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['sex']) ? htmlspecialchars($patient['sex'] == 'f' ? "Féminin" : "Masculin") : '-') . "</td>";
        echo "<td>" . (!empty($patient['born_date']) ? htmlspecialchars($patient['born_date']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['email']) ? htmlspecialchars($patient['email']) : '-') . "</td>";
        echo "<td>" . (!empty($patient['phone']) ? htmlspecialchars($patient['phone']) : '-') . "</td>";
        echo "<td>";
        echo '<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';
        echo '<a href="#deleteEmployeeModal" class="delete btn-line" data-toggle="modal" data-id="' . htmlspecialchars($patient['security_number']) . '"> <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
        echo "</td>";
        echo "</tr>";
    }
}
else
{
    echo "<tr><td colspan='9' style='text-align: center;'>Aucun patient trouvé.</td></tr>";
}
?>
