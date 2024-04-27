<?php include("./connexion_add_patient.php"); ?>

<div id="addEmployeeModal" class="modal fade" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="form_add_patient">
				<div class="modal-header">						
					<h4 class="modal-title">Ajouter</h4>
					<span type="button" class="close" data-dismiss="modal" aria-hidden="true">×</span>
				</div>
				<div class="modal-body">

                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>

                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>

                <div class="form-group">
                    <label>Deuxième Prénom</label>
                    <input type="text" class="form-control" name="second_name" required>
                </div>

                <div class="form-group">
                    <label for="sexe">Sexe</label>
                    <select id="sexe" class="form-control" name="sexe" required>
                        <option value="feminin">Féminin</option>
                        <option value="masculin">Masculin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Numéro de Sécurité Social</label>
                    <input type="text" class="form-control" name="security_number" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label>Adresse</label>
                    <textarea class="form-control" name="adresse" required></textarea>
                </div>

                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" class="form-control" name="telephone" required>
                </div>

                <div class="form-group">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" class="form-control" name="date_naissance" required>
                </div>

                
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
					<input type="submit" class="btn btn-success" value="Valider">
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include("./toast_error_patient.php");
include("./toast_valid_patient.php");
?>