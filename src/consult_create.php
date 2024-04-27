<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prendre rendez-vous</title>
    <?php include './includes.html'; ?>
</head>
<body>
<?php include './header.php'; ?>

<?php
$startDate = isset($_GET['eventStartDate']) ? $_GET['eventStartDate'] : '';
$startDate = htmlspecialchars($startDate, ENT_QUOTES, 'UTF-8');

try {
    $dateTime = new DateTime($startDate);
    $formattedDate = $dateTime->format('Y-m-d\TH:i');
} catch (Exception $e) {
    $formattedDate = '';
}
?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Planifier une tâche</h4>
    <form method="post" id="add_task_form" class="needs-validation" action="consult-add" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date_slot">Date et Heure de début</label>
                <input type="datetime-local" class="form-control" id="start_date_slot" name="start_date_slot" value="<?php echo $formattedDate; ?>" readonly  required>
                <?php if (!empty($errors['start_date_slot'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['start_date_slot']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-12 mb-3">
                <label>Autres patients</label>
                <div id="other_patients_container">
                    <!-- Les champs pour les autres patients seront ajoutés ici dynamiquement -->
                </div>
                <button type="button" class="btn btn-primary mb-2" id="add_patient_btn">Ajouter un autre patient</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-success" type="submit">Valider</button>
            </div>
        </div>
    </form>
</div>

<?php include './end.html'; ?>
<?php include './include_js.html'; ?>

<script>
    $(document).ready(function() {
        $('#add_patient_btn').click(function() {
            if ($('.line-patient').length >= 2) {
                return ;
            }
            $('#other_patients_container').append(`
            <div class="row mt-2 line-patient">
                <div class="col">
                    <input type="text" class="form-control" name="patient_security_number[]" placeholder="Numéro de sécurité social du patient" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove_patient_btn">X</button>
                </div>
            </div>
        `);
            if ($('.line-patient').length >= 2) {
                $('#add_patient_btn').css('display', "none");
            }
        });

        // Retirer un champ patient
        $(document).on('click', '.remove_patient_btn', function() {
            $(this).closest('.row').remove();
            $('#add_patient_btn').css('display', "flex");
        });
    });
</script>
</body>
</html>
