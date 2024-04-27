<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Disponibilité</title>
    <?php include './includes.html';
    include './connexion_add_slot.php';
    ?>
</head>
<body>
<?php include './header.html'; ?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Ajouter Disponibilité</h4>
    <form method="post" id="add_slot_form" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="start_time">Heure de début</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_time">Heure de fin</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
        </div>
        <button class="btn btn-success btn-block" type="submit">Valider</button>
    </form>
</div>

<?php include './end.html'; ?>
<?php include './include_js.html'; ?>
</body>
</html>
