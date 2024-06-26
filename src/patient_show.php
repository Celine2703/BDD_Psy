<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Éditer Patient</title>
    <?php include './includes.html'; ?>
</head>
<body>
<?php include './header.php'; ?>

<?php
if (isset($_GET['id'])) {
    $security_number = htmlspecialchars($_GET['id']);

    include_once("loadEnv.php");
    loadEnv();
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $dbname = $_ENV['DB_NAME'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM patient WHERE security_number = :security_number");
        $stmt->bindParam(':security_number', $security_number);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

if (!$result) {
    echo "<p>Patient non trouvé.</p>";
} else {

    // Chargement des jobs liés au patient avec dates
    $jobs_stmt = $conn->prepare("SELECT j.name, te.start_date, te.end_date FROM to_execute te JOIN job j ON te.name = j.name WHERE te.security_number = :security_number");
    $jobs_stmt->bindParam(':security_number', $security_number);
    $jobs_stmt->execute();
    $jobs = $jobs_stmt->fetchAll(PDO::FETCH_ASSOC);

// Chargement des consultations passées et futures
    $now = new DateTime();
    $consultations_stmt = $conn->prepare("SELECT * FROM to_consult WHERE security_number = :security_number ORDER BY start_date_slot");
    $consultations_stmt->bindParam(':security_number', $security_number);
    $consultations_stmt->execute();
    $consultations = $consultations_stmt->fetchAll(PDO::FETCH_ASSOC);
    $future_consultations = [];
    $past_consultations = [];
    foreach ($consultations as $consultation) {
        $consultation_date = new DateTime($consultation['start_date_slot']);
        if ($consultation_date > $now) {
            $future_consultations[] = $consultation;
        } else {
            $past_consultations[] = $consultation;
        }
    }

    $connUser = new PDO("mysql:host=" . $_ENV['DB_C_HOST'] . ";dbname=" . $_ENV['DB_C_NAME'], $_ENV['DB_C_USER'], $_ENV['DB_C_PASS']);
    $connUser->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $checkUser = $connUser->prepare("SELECT security_number FROM users WHERE security_number = ?");
    $checkUser->execute([$security_number]);
    $userExists = $checkUser->fetch();

    if ($userExists) {
        $inviteUserLabel = "Mot de passe oublié ?";
    } else {
        $inviteUserLabel = "Inviter";

    }

    // Calcul de l'âge à partir de la date de naissance
    $dateOfBirth = new DateTime($result['born_date']);
    $today = new DateTime();
    $age = $today->diff($dateOfBirth)->y;


// Détermination de la catégorie d'âge
    if ($age < 3) {
        $category = "Bébé";
    } elseif ($age < 12) {
        $category = "Enfant";
    } elseif ($age < 18) {
        $category = "Adolescent";
    } else {
        $category = $result['sex'] == "f" ? "Femme" : "Homme";
    }

    $firstConsultStmt = $conn->prepare("SELECT start_date_slot FROM to_consult WHERE security_number = :security_number ORDER BY start_date_slot ASC LIMIT 1");
    $firstConsultStmt->bindParam(':security_number', $security_number);
    $firstConsultStmt->execute();
    $firstConsultation = $firstConsultStmt->fetch(PDO::FETCH_ASSOC);
    $firstConsultationDate = $firstConsultation ? (new DateTime($firstConsultation['start_date_slot']))->format('d/m/Y H:i') : "Pas de consultations enregistrées";

    ?>

        <?php if ($age >= 18) :?>
            <div class="">
                <class class="col-9" style=""></class>
                <a href="invite-user?id=<?php echo $result['security_number']; ?>"  id="inviteUserBtn" class="btn btn-primary" style="margin-top: 10px; margin-left: 80%;"><?= $inviteUserLabel?></a>
            </div>
        <?php endif?>

    <div class="container mt-5 mb-5">
        <h4 class="mb-3">Éditer les informations du patient</h4>
        <form method="post" id="edit_patient_form" class="needs-validation" action="update-patient" novalidate>
            <input type="hidden" name="security_number" value="<?php echo $result['security_number']; ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" id="firstname" value="<?php echo htmlspecialchars($result['firstname']); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="second_name">Deuxième Prénom</label>
                    <input type="text" class="form-control" id="second_name" value="<?php echo htmlspecialchars($result['second_name']); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" id="lastname" value="<?php echo htmlspecialchars($result['lastname']); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sex">Sexe</label>
                    <input type="text" class="form-control" id="sex" value="<?php echo htmlspecialchars($result['sex']) == "f" ? "féminin" : "masculin"; ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="born_date">Date de naissance</label>
                    <input type="date" class="form-control" id="born_date" value="<?php echo htmlspecialchars($result['born_date']); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="age">Âge</label>
                    <input type="text" class="form-control" id="age" value="<?php echo $age . ' ans - ' . $category; ?>" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="known_by">Connu par</label>
                    <input type="text" class="form-control" id="known_by" name="known_by" value="<?php echo htmlspecialchars($result['known_by']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($result['email']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone">Téléphone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($result['phone']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="first_consultation_date">Première Consultation</label>
                    <input type="text" class="form-control" id="first_consultation_date" value="<?php echo $firstConsultationDate; ?>" disabled>
                </div>
                <!-- Jobs liés au patient -->
                <div class="col-md-12 mb-3">
                    <label>Jobs liés au patient</label>
                    <div id="jobs_container">
                        <?php if (!empty($jobs)): ?>
                            <?php foreach ($jobs as $job): ?>
                                <div class="row job-line">
                                    <div class="col-md-5">
                                        <label for="">Nom du job</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($job['name']); ?>" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Date de Début</label>
                                        <input type="date" class="form-control" value="<?php echo htmlspecialchars((new DateTime($job['start_date']))->format('Y-m-d')); ?>" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Date de Fin</label>
                                        <input type="date" class="form-control" placeholder="Date de Fin"   value="<?php echo htmlspecialchars((new DateTime($job['end_date']))->format('Y-m-d')); ?>" readonly>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun job trouvé.</p>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-primary mb-2" id="add_job_btn">Ajouter un job</button>
                </div>

                <!-- Consultations futures -->
                <div class="col-md-12 mb-3">
                    <label>Consultations futures</label>
                    <div id="future_consultations_container">
                        <?php if (count($future_consultations) > 0): ?>
                            <?php foreach ($future_consultations as $consultation): ?>
                                <input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($consultation['start_date_slot']); ?>" disabled>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune consultation future trouvée.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Consultations passées -->
                <div class="col-md-12 mb-3">
                    <label>Consultations passées</label>
                    <div id="past_consultations_container">
                        <?php if (count($past_consultations) > 0): ?>
                            <?php foreach ($past_consultations as $consultation): ?>
                                <input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($consultation['start_date_slot']); ?>" disabled>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune consultation passée trouvée.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">Mettre à jour</button>
                </div>
            </div>
        </form>
    </div>

<?php } ?>

<?php include './end.html'; ?>
<?php include './include_js.html'; ?>
<script>
    $(document).ready(function() {
        $('#add_job_btn').click(function() {
            $('#jobs_container').append(`
            <div class="row mt-2 job-line">
                <div class="col-md-5">
                    <label for="">Nom du job</label>
                    <input type="text" class="form-control" name="job_names[]" placeholder="Nom du job" required>
                </div>
                <div class="col-md-2">
                    <label for="">Date de Début</label>
                    <input type="date" class="form-control" name="job_start_dates[]" placeholder="Date de début" required>
                </div>
                <div class="col-md-2">
                    <label for="">Date de Fin</label>
                    <input type="date" class="form-control" name="job_end_dates[]" placeholder="Date de Fin" required>
                </div>
                <div class="col-md-2">
                    <label> </label>
                    <button type="button" class="btn btn-danger remove_job_btn">X</button>
                </div>
            </div>
        `);
        });

        $(document).on('click', '.remove_job_btn', function() {
            $(this).closest('.row').remove();
        });

        $(document).on('click', '.remove_consultation_btn', function() {
            // Logique pour supprimer la consultation de la base de données
            $(this).closest('.row').remove();
        });
    });
</script>

<style>
    label {
        font-weight: bold;
    }

    .row.job-line {
        margin-top: 5px;
    }

    #add_job_btn {
        margin-top: 10px;
    }

</style>
</body>
</html>

