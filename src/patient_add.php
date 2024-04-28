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
    <?php include  './connexion_add_patient.php'; ?>
</head>
<body>
<?php include './header.php'; ?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Ajouter un patient</h4>
    <form method="post" id="form_add_patient" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="lastname">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>">
                <!-- Aucun message d'erreur spécifique pour le nom car non mentionné dans la demande -->
            </div>
            <div class="col-md-6 mb-3">
                <label for="firstname">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
                <!-- Aucun message d'erreur spécifique pour le prénom car non mentionné dans la demande -->
            </div>
            <div class="col-md-6 mb-3">
                <label for="second_name">Deuxième Prénom</label>
                <input type="text" class="form-control" id="second_name" name="second_name" required value="<?php echo htmlspecialchars($_POST['second_name'] ?? ''); ?>">
                <!-- Aucun message d'erreur spécifique pour le deuxième prénom car non mentionné dans la demande -->
            </div>
            <div class="col-md-6 mb-3">
                <label for="sexe">Sexe</label>
                <select id="sexe" class="form-control" name="sexe" required>
                    <option value="f" <?php echo (isset($_POST['sexe']) && $_POST['sexe'] == 'feminin') ? 'selected' : ''; ?>>Féminin</option>
                    <option value="m" <?php echo (isset($_POST['sexe']) && $_POST['sexe'] == 'masculin') ? 'selected' : ''; ?>>Masculin</option>
                </select>
                <!-- Aucun message d'erreur spécifique pour le sexe car non mentionné dans la demande -->
            </div>
            <div class="col-md-6 mb-3">
                <label for="security_number">Numéro de Sécurité Social</label>
                <input type="text" class="form-control" id="security_number" name="security_number" required value="<?php echo htmlspecialchars($_POST['security_number'] ?? ''); ?>">
                <?php if (!empty($errors['security_number'])): ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['security_number']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <?php if (!empty($errors['email'])): ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="adresse">Adresse</label>
                <textarea class="form-control" id="adresse" name="adresse" required><?php echo htmlspecialchars($_POST['adresse'] ?? ''); ?></textarea>
                <!-- Aucun message d'erreur spécifique pour l'adresse car non mentionné dans la demande -->
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" required value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                <?php if (!empty($errors['phone'])): ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required value="<?php echo htmlspecialchars($_POST['date_naissance'] ?? ''); ?>">
                <?php if (!empty($errors['date_naissance'])): ?>
                    <div class="alert alert-danger mt-2"><?php echo $errors['date_naissance']; ?></div>
                <?php endif; ?>
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
