<html lang="en"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Patient</title>
<?php 
      include './includes.html';
	  include './connexion_show_list.php';
    ?>

</head>


<body class="list_patient">

<?php include './header.html'; ?>
<div class="container" style="margin-bottom: -100px;">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Gérer les <b>Patients</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Ajouter</span></a>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">

				<thead>
					<tr>
						<th>Securité social</th>
						<th>Prénom</th>
                        <th>Second Prénom</th>
						<th>Nom</th>
						<th>Sexe</th>
						<th style="min-width: 130px;">Date de naissance</th>
						<th>Email</th>
						<th>Téléphone</th>
						<th class="actions"></th>
					</tr>
				</thead>

				<tbody>
					<!-- pour chaque patient dans la liste des patients on affiche les informations du patient dans une ligne du tableau  -->
					<?php include './patient_line_list.php'; ?>
					<!-- end affiche -->
				</tbody>

			</table>
		</div>
		<?php
		// Nombre total de pages
		$totalPages = 25;

		// Page actuelle
		$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
		$currentPage = max(1, min($totalPages, $currentPage)); // Assure que la page est dans les limites

		// Nombre de pages à afficher avant de commencer à afficher les pages suivantes
		$offset = 5;

		?>

		<div class="clearfix" id="paginator">
			<div class="hint-text" id="paginator_actual"><b><?php echo $currentPage; ?></b> sur <b><?php echo $totalPages; ?></b> au total</div>
			<ul class="pagination">
				<li class="page-item disabled"><a href="#">Précédent</a></li>

				<?php
				// Boucle pour générer les pages de la pagination
				for ($i = $currentPage; $i < $currentPage + $offset && $i <= $totalPages; $i++) {
					// Si la page est la page active, ajoutez la classe active
					$class = ($i == $currentPage) ? "page-item active" : "page-item";
					echo "<li class='" . $class . "'><a href='#' class='page-link'>" . $i . "</a></li>";
				}
				?>

				<li class="page-item"><a href="#" class="page-link">Suivant</a></li>
			</ul>
		</div>
</div>
</div>



</body>
<?php
include './patient_add.php';
include './patient_edit.php';
include './patient_delete.php';

include './end.html'; ?>
</html>