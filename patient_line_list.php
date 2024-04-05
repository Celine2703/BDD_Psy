<?php 
    if ($patients) {
        foreach ($patients as $patient) {
            echo "<tr>";
            echo "<td><input type='checkbox' class='checkbox' data-id='" . $patient['security_number'] . "'></td>";
            echo "<td data-id='" . $patient['security_number'] . "'>" . $patient['security_number'] . "</td>";
            echo "<td>" . $patient['firstname'] . "</td>";
            echo "<td>" . $patient['lastname'] . "</td>";
            // echo "<td>" . $patient['email'] . "</td>";
            echo "<td>" . $patient['born_date'] . "</td>";
            echo "<td>" . $patient['known_by'] . "</td>";
            echo "<td>";
            echo '<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';
            echo '<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Aucun patient trouvé.</td></tr>";
    }
?>