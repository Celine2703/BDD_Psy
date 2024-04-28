<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Patient</title>
    <?php include './check_admin.php';
    include './includes.html'; ?>
</head>
<body>
<?php include './header.php'; ?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Enregistrer une consultation</h4>
    <form method="post" id="form_add_consultation" class="needs-validation" action="" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date_slot">Date et Heure de début</label>
                <input type="datetime-local" class="form-control" id="start_date_slot" name="start_date_slot" required value="<?php echo htmlspecialchars($_POST['start_date_slot'] ?? ''); ?>" disabled>
            </div>
            <div class="col-md-6 mb-3">
                <label for="arrival_date_consult">Heure d'arrivée</label>
                <input type="datetime-local" class="form-control" id="arrival_date_consult" name="arrival_date_consult">
            </div>
            <div class="col-md-6 mb-3">
                <label for="price">Prix (€)</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01">
            </div>
            <div class="col-md-6 mb-3">
                <label for="payment_method">Méthode de paiement</label>
                <input type="text" class="form-control" id="payment_method" name="payment_method">
            </div>
            <div class="col-md-6 mb-3">
                <label for="anxiety_index">Indice d'anxiété (1-10)</label>
                <input type="number" class="form-control" id="anxiety_index" name="anxiety_index" min="1" max="10">
            </div>
            <div class="col-md-6 mb-3">
                <label for="observations">Observations</label>
                <textarea class="form-control" id="observations" name="observations"></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="security_number">Numéro de Sécurité Sociale</label>
                <input type="text" class="form-control" id="security_number" name="security_number" required value="<?php echo htmlspecialchars($_POST['security_number'] ?? ''); ?>" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button class="btn btn-success btn-block" type="submit">Enregistrer</button>
                <a href="./consultation" class="btn btn-danger btn-block mt-2">Annuler</a>
            </div>
        </div>
    </form>
</div>


<?php include './end.html'; ?>
<?php include './include_js.html'; ?>

</body>
</html>



