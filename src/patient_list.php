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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="filters">
                <h4 class="mt-5">Filtres</h4>
                <form id="filters-form">
                    <div class="form-group">
                        <label for="age">Âge:</label>
                        <select class="form-control" id="age" name="age">
                            <option value="">Tous</option>
                            <option value="0-12">Moins de 12 ans</option>
                            <option value="12-18">12 à 18 ans</option>
                            <option value="18+">Plus de 18 ans</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sex-filter">Sexe:</label>
                        <select class="form-control" id="sex-filter" name="sex">
                            <option value="">Tous</option>
                            <option value="f">Féminin</option>
                            <option value="m">Masculin</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="applyFilters()">Appliquer</button>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="table-responsive">
                <div class="search">
                    <form id="search-form">
                        <div class="d-flex">
                            <div class="col-md-11">
                                <input type="text" name="search" id="search-input" class="form-control" placeholder="Rechercher par nom, prenom, sécurité social, téléphone, email, ...">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="applySearch()"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
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
                        <?php include './patient_line_list.php'; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Définition des variables globales pour gérer l'état actuel du tri
    var currentColumn = 'security_number'; // colonne de tri initiale
    var currentOrder = 'asc'; // ordre de tri initial

    function applyFilters() {
        var formData = $('#filters-form').serialize();
        // Inclure le tri courant et le terme de recherche dans la requête de filtrage
        formData += '&column=' + currentColumn + '&order=' + currentOrder;
        updateTableData(formData);
    }


    function applySearch() {
        var searchValue = $('#search-input').val();
        var formData = 'search=' + encodeURIComponent(searchValue) + '&column=' + currentColumn + '&order=' + currentOrder;
        updateTableData(formData);
    }

    function updateTableData(formData) {
        $.ajax({
            url: './src/sortPatients.php',
            type: 'GET',
            data: formData,
            success: function(data) {
                $('tbody').html(data);
            }
        });
    }

    $(document).ready(function() {

        $('.sortable').click(function() {
            currentColumn = $(this).data('column');
            var order = $(this).data('order');
            currentOrder = order === 'asc' ? 'desc' : 'asc';
            $(this).data('order', currentOrder);

            // Appliquer le tri en conservant les filtres actuels
            var formData = $('#filters-form').serialize() + '&search=' + encodeURIComponent($('#search-input').val());
            formData += '&column=' + currentColumn + '&order=' + currentOrder;
            updateTableData(formData);
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