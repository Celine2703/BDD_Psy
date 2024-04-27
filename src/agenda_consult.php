<html lang='en'>
<head>
    <meta charset='utf-8' />
    <link rel="icon" type="image/png" href="images/logo.png">


    <?php
    include './includes.html'
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>

    <link rel="stylesheet" href="css/core_agenda.css">
</head>
<body>
<?php include 'header.html'; ?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Planifier une tâche</h4>
    <form method="post" id="add_task_form" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date_slot">Date et Heure de début</label>
                <input type="datetime-local" class="form-control" id="start_date_slot" name="start_date_slot" required>
            </div>
            <div class="col-md-12">
                <label>Autres patients</label>
                <div id="other_patients_container">
                </div>
                <button type="button" class="btn btn-primary" id="add_patient_btn">Ajouter un autre patient</button>
            </div>
        </div>
        <button class="btn btn-success btn-block" type="submit">Valider</button>
    </form>
</div>

<div id="hearder_agenda">
    <h3>Mes consultations : </h3>
</div>
<div id='calendar'></div>


<?php include 'end.html'; ?>

<script src="js/core_agenda.js"></script>

</body>
</html>
