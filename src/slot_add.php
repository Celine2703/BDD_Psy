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
                <?php if (isset($errors['date'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['date']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-3 mb-3">
                <label for="start_time">Heure de début</label>
                <select class="form-control" id="start_time" name="start_time" required>
                    <?php
                    for ($hour = 9; $hour < 22; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 15) {
                            $formattedTime = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);
                            echo "<option value=\"$formattedTime\">$formattedTime</option>";
                        }
                    }
                    ?>
                </select>
                <?php if (isset($errors['start_datetime'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['start_datetime']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_time">Heure de fin</label>
                <select class="form-control" id="end_time" name="end_time" required>
                    <?php
                    for ($hour = 9; $hour < 22; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 15) {
                            $formattedTime = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);
                            echo "<option value=\"$formattedTime\">$formattedTime</option>";
                        }
                    }
                    ?>
                </select>
                <?php if (isset($errors['end_datetime'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['end_datetime']; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <button class="btn btn-success btn-block" type="submit">Valider</button>
    </form>
</div>

<?php include './end.html'; ?>
<?php include './include_js.html'; ?>
</body>
</html>
