<html lang="en"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Patient</title>
<?php 
      include './includes.html';
	  include './connexion_show_list.php';
        include './check_admin.php';
    ?>

</head>


<body class="list_patient">

<?php include './header.php'; ?>
<div class="container" style="">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row" style="display: flex; align-items: center; justify-content: space-between;">
					<div>
						<h2>Gérer les <b>Patients</b></h2>
					</div>

				<div>
					<a href="./patient-create" class="btn btn-success"><i class="material-icons"></i> <span>Ajouter</span></a>
				</div>
			</div>

			</div>
			<table class="table table-striped table-hover">

                <thead>
                <tr>
                    <th data-column="security_number" data-order="asc" class="sortable">Securité social</th>
                    <th data-column="firstname" data-order="asc" class="sortable">Prénom</th>
                    <th data-column="second_name" data-order="asc" class="sortable">Second Prénom</th>
                    <th data-column="lastname" data-order="asc" class="sortable">Nom</th>
                    <th data-column="sex" data-order="asc" class="sortable">Sexe</th>
                    <th data-column="born_date" data-order="asc" class="sortable" style="min-width: 130px;">Date de naissance</th>
                    <th data-column="email" data-order="asc" class="sortable">Email</th>
                    <th data-column="phone" data-order="asc" class="sortable">Téléphone</th>
                    <th class="actions">Actions</th>
                </tr>
                </thead>

				<tbody>
					<!-- pour chaque patient dans la liste des patients on affiche les informations du patient dans une ligne du tableau  -->
					<?php include './patient_line_list.php'; ?>
					<!-- end affiche -->
				</tbody>

			</table>
		</div>
</div>
</div>


<script>
    $(document).ready(function() {
        $('.sortable').click(function() {
            var column = $(this).data('column');
            var order = $(this).data('order');
            var newOrder = order === 'asc' ? 'desc' : 'asc';
            $(this).data('order', newOrder);

            $.ajax({
                url: './src/sortPatients.php',
                type: 'GET',
                data: {
                    column: column,
                    order: newOrder
                },
                success: function(data) {
                    $('tbody').html(data);
                    // Mettre à jour l'ordre de tri pour refléter le changement
                    $('.sortable[data-column="' + column + '"]').data('order', newOrder);
                }
            });
        });
    });
</script>
<style>
    .table-slot th, .table-slot td {
        text-align: center;
    }
    .sortable:hover {
        cursor: pointer;
        color: gray;
    }
</style>
</body>
<?php
include './patient_edit.php';
include './patient_delete.php';

include './end.html'; ?>
</html>