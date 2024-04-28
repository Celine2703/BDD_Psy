<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
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
    <title>Consultations</title>
    <?php
    include './includes.html';
    include './connexion_list.php';

    ?>

</head>

<body>

<?php include 'header.php';
$_SESSION['errors'] = [];
$_SESSION['form_data'] = [];
?>

<div class="container" style="">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Compléter mes <b>RDV</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-slot">

                <thead>
                <tr>
                    <th data-column="start_date_slot" data-order="asc" class="sortable">Date</th>
                    <th data-column="start_date_slot" data-order="asc" class="sortable">Heure de début</th>
                    <th data-column="start_date_slot" data-order="asc" class="sortable">Heure de fin</th>
                    <th data-column="security_number" data-order="asc" class="sortable">Patient</th>
                    <th data-column="status" data-order="asc" class="sortable">Status</th>
                    <th class="actions">Actions</th>
                </tr>
                </thead>

                <tbody>
                <!-- pour chaque patient dans la liste des patients on affiche les informations du patient dans une ligne du tableau  -->
                <?php include './consult_line_list_tocomplete.php'; ?>
                <!-- end affiche -->
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include './consult_delete.php';
include 'end.html'; ?>

<?php include './include_js.html'; ?>
</body>

</html>

<script>
    $(document).ready(function() {
        $('.sortable').click(function() {
            var $this = $(this);
            var column = $this.data('column');
            var order = $this.data('order');
            var newOrder = order === 'asc' ? 'desc' : 'asc';

            $.ajax({
                url: './src/sortConsult.php',
                type: 'GET',
                data: {
                    column: column,
                    order: newOrder
                },
                success: function(data) {
                    $('tbody').html(data);
                    // Reset all to 'asc' except the current clicked one
                    $('.sortable').data('order', 'asc'); // Reset all to 'asc'
                    $this.data('order', newOrder); // Set clicked header to new order
                }
            });
        });
    });
</script>

<style>
    .table-slot th, .table-slot td {
        text-align: center;
    }

    form {
        padding: 0px;
        margin: 0px;
        margin-left: auto;
        margin-right: 30px;
        width: 0px;
    }
</style>
<style>
    .table-slot th, .table-slot td {
        text-align: center;
    }
    .sortable:hover {
        cursor: pointer;
        color: gray;
    }
</style>