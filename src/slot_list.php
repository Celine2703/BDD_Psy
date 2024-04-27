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
    include './includes.html';
    include './connexion_slot.php';

    ?>

</head>

<body>

<?php include 'header.html'; ?>

<div class="container" style="">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Gérer mes <b>disponibilités</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="./slot-create" class="btn btn-success"><i class="material-icons"></i> <span>Ajouter</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-slot">

                <thead>
                <tr>
                    <th style="width: 120px;">Date</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <th>Disponible</th>
                    <th class="actions"></th>
                </tr>
                </thead>

                <tbody>
                <!-- pour chaque patient dans la liste des patients on affiche les informations du patient dans une ligne du tableau  -->
                <?php include './slot_line_list.php'; ?>
                <!-- end affiche -->
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include 'end.html'; ?>

<?php include './include_js.html'; ?>
</body>

</html>

<style>
    .table-slot th, .table-slot td {
        text-align: center;
    }
</style>