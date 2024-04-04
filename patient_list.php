<html lang="en"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Patient</title>
<?php 
      include './includes.html' 
    ?>

</head>


<body class="list_patient">

<?php include './header.html'; ?>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Gérer les <b>Patients</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Ajouter</span></a>
						<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons"></i> <span>Supprimer</span></a>						
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">

				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>Securité social</th>
						<th>Nom</th>
						<th>Email</th>
						<th>Téléphone</th>
						<th class="actions"></th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox1" name="options[]" value="1">
								<label for="checkbox1"></label>
							</span>
						</td>
						<td id="security_number">12345678912354</td>
						<td id="fullname">Thomas Hardy</td>
						<td id="email">thomashardy@mail.com</td>
						<td id="telephone">06 64 35 38 63</td>

						<td>
							<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>
							<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="" data-original-title="Delete"></i></a>
						</td>
					</tr>
				</tbody>

			</table>
		</div>
		<div class="clearfix" id="paginator">
				<div class="hint-text" id="paginator_actual"><b>5</b> sur <b>25</b> au total</div>
				<ul class="pagination">
					<li class="page-item disabled"><a href="#">Précédent</a></li>
					<li class="page-item"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item active"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link">4</a></li>
					<li class="page-item"><a href="#" class="page-link">5</a></li>
					<li class="page-item"><a href="#" class="page-link">Suivant</a></li>
				</ul>
			</div>
	</div>        
</div>




<?php
include './patient_add.php';
include './patient_edit.php';
include './patient_delete.php';

include './end.html'; ?>
</body></html>