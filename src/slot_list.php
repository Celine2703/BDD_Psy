<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Site Metas -->
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Mes disponibilités</title>
    <?php
    include './check_admin.php';
    include './includes.html';
    include './connexion_slot.php';

    ?>

</head>


<body>
<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="filters">
                <h4 class="mt-5">Filtres</h4>
                <form id="filters-form">
                    <div class="form-group">
                        <label for="date-from">Date de début:</label>
                        <input type="date" class="form-control" id="date-from" name="date_from">
                    </div>
                    <div class="form-group">
                        <label for="date-to">Date de fin:</label>
                        <input type="date" class="form-control" id="date-to" name="date_to">
                    </div>
                    <div class="form-group">
                        <label for="status-filter">Statut:</label>
                        <select class="form-control" id="status-filter" name="status">
                            <option value="">Tous</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Réservé">Réservé</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="applyFilters()">Appliquer</button>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h2>Gérer mes <b>disponibilités</b></h2></div>
                            <div class="col-sm-4">
                                <a href="./slot-create" class="btn btn-success"><i class="material-icons"></i> <span>Ajouter</span></a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-slot">
                        <thead>
                        <tr>
                            <th data-column="formatted_date" data-order="asc" class="sortable">Date</th>
                            <th data-column="start_time" data-order="asc" class="sortable">Heure de début</th>
                            <th data-column="end_time" data-order="asc" class="sortable">Heure de fin</th>
                            <th data-column="status" data-order="asc" class="sortable">Statut</th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php include './slot_line_list.php'; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './slot_delete.php'; ?>
<?php include 'end.html'; ?>
<?php include './include_js.html'; ?>
</body>

<script>
    $(document).ready(function() {
        $('.sortable').click(function() {
            var column = $(this).data('column');
            var order = $(this).data('order');
            var newOrder = order === 'asc' ? 'desc' : 'asc';
            $(this).data('order', newOrder);

            $.ajax({
                url: './src/sortSlot.php',
                type: 'GET',
                data: {
                    column: column,
                    order: newOrder
                },
                success: function(data) {
                    $('tbody').html(data);
                }
            });
        });
    });
</script>
<script>
    function applyFilters() {
        console.log("applyFilters");
        var formData = $('#filters-form').serialize(); // Collect data from form
        $.ajax({
            url: './src/sortSlot.php', // Assuming you have a PHP file to handle the filter
            type: 'GET',
            data: formData,
            success: function(data) {
                $('tbody').html(data); // Update the table body
            }
        });
    }
</script>
</html>

<style>
    .table-slot th, .table-slot td {
        text-align: center;
    }
    .sortable:hover {
        cursor: pointer;
        color: gray;
    }
</style>