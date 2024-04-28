<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Patient</title>
    <?php include './check_admin.php';
    include './includes.html';
    $formData = $_SESSION['form_data'] ?? null;
    $errors = $_SESSION['errors'] ?? [];?>
</head>
<body>
<?php include './header.php'; ?>
<?php
include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// Vérifie si les identifiants de la consultation sont passés
$security_number = $_SESSION['security_number'] ?? '';
$start_date_slot = $formData['start_date_slot'] ?? '';

$errors = $_SESSION['errors'] ?? [];

if ($security_number && $start_date_slot) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM to_consult WHERE security_number = :security_number AND start_date_slot = :start_date_slot");
        $stmt->bindParam(':security_number', $security_number);
        $stmt->bindParam(':start_date_slot', $start_date_slot);
        $stmt->execute();

        // Récupère les données de la consultation si elle existe
        $formData = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Nettoyage de la session
$_SESSION['errors'] = [];
$_SESSION['form_data'] = '';

?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Enregistrer une consultation</h4>
    <form method="post" id="form_add_consultation" class="needs-validation" action="./src/post_consult_validator.php" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date_slot">Date et Heure de début</label>
                <input type="datetime-local" class="form-control" id="start_date_slot" name="start_date_slot" required value="<?php echo htmlspecialchars($formData['start_date_slot'] ?? $_POST['start_date_slot'] ?? ''); ?>" readonly>
                <?php if (isset($errors['start_date_slot'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['start_date_slot']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="arrival_date_consult">Heure d'arrivée</label>
                <input type="datetime-local" class="form-control" id="arrival_date_consult" name="arrival_date_consult" value="<?php echo htmlspecialchars($formData['start_date_slot'] ?? $_POST['start_date_slot'] ?? ''); ?>"  >
                <?php if (isset($errors['arrival_date_consult'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['arrival_date_consult']; ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="price">Prix (€)</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($formData['price'] ?? ''); ?>">
                <?php if (isset($errors['price'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['price']; ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="payment_method">Méthode de paiement</label>
                <input type="text" class="form-control" id="payment_method" name="payment_method" value="<?php echo htmlspecialchars($formData['payment_method'] ?? ''); ?>">
                <?php if (isset($errors['payment_method'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['payment_method']; ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="anxiety_index">Indice d'anxiété (1-10)</label>
                <input type="number" class="form-control" id="anxiety_index" name="anxiety_index" min="1" max="10" value="<?php echo htmlspecialchars($formData['anxiety_index'] ?? ''); ?>">
                <?php if (isset($errors['anxiety_index'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['anxiety_index']; ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="observations">Observations</label>
                <textarea class="form-control" id="observations" name="observations"><?php echo htmlspecialchars($formData['observations'] ?? ''); ?></textarea>
                <?php if (isset($errors['observations'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['observations']; ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="security_number">Numéro de Sécurité Sociale</label>
                <input type="text" class="form-control" id="security_number" name="security_number" required value="<?php echo htmlspecialchars($formData['security_number'] ?? $_POST['security_number'] ?? ''); ?>" readonly>
                <?php if (isset($errors['security_number'])): ?>
                    <div class="alert alert-danger"><?php echo $errors['security_number']; ?></div>
                <?php endif; ?>
            </div>

        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button class="btn btn-success btn-block" type="submit">Enregistrer</button>
                <a href="./post-consult" class="btn btn-danger btn-block mt-2">Annuler</a>
            </div>
        </div>
    </form>
</div>


<?php include './end.html'; ?>
<?php include './include_js.html'; ?>

</body>
</html>



