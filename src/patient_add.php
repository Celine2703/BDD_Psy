<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Patient</title>
    <?php include './includes.html'; ?>
    <?php include './connexion_add_patient.php'; ?>
</head>
<body>
<?php include './header.html'; ?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Ajouter un patient</h4>
    <form method="post" id="form_add_patient" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="lastname">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="firstname">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="second_name">Deuxième Prénom</label>
                <input type="text" class="form-control" id="second_name" name="second_name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sexe">Sexe</label>
                <select id="sexe" class="form-control" name="sexe" required>
                    <option value="feminin">Féminin</option>
                    <option value="masculin">Masculin</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="security_number">Numéro de Sécurité Social</label>
                <input type="text" class="form-control" id="security_number" name="security_number" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger mt-2">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="adresse">Adresse</label>
                <textarea class="form-control" id="adresse" name="adresse" required></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button class="btn btn-success btn-block" type="submit">Valider</button>
                <a href="./patient" class="btn btn-danger btn-block mt-2">Annuler</a>
            </div>
        </div>


    </form>
</div>

<?php include './end.html'; ?>
<?php include './include_js.html'; ?>
</body>
</html>
