<!--Rayan Anki-->
<!--Colombe Blachère-->
<!--Céline Martin-Parisot-->
<!--L3-APP LSI2-->
<?php

session_start();

include_once("loadEnv.php");
loadEnv();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$errors = [];
$success = '';
$_SESSION['errors'] = [];
$_SESSION['form_data'] = '';


$requiredFields = [
    'arrival_date_consult', 'price', 'payment_method', 'anxiety_index', 'observations', 'security_number' // 'start_date_slot' removed from required fields as it is disabled
];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field]) && $_POST[$field] !== '0') {
        $errors[$field] = "Ce champ ne peut être vide.";
    }
}

if (!empty($_POST['price']) && !is_numeric($_POST['price'])) {
    $errors['price'] = "Le prix doit être un nombre valide.";
}

if (!empty($_POST['anxiety_index']) && ($_POST['anxiety_index'] < 1 || $_POST['anxiety_index'] > 10)) {
    $errors['anxiety_index'] = "L'indice d'anxiété doit être entre 1 et 10.";
}

if (!empty($_POST['arrival_date_consult']) && $arrivalDateTime = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['arrival_date_consult']) === false) {
    $errors['arrival_date_consult'] = "Le format de la date d'arrivée n'est pas valide.";
}

$start_date_slot = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['start_date_slot']);
$start_date_slot_mysql = $start_date_slot ? $start_date_slot->format('Y-m-d H:i:s') : null;

$arrival_date_consult = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['arrival_date_consult']);
$arrival_date_consult_mysql = $arrival_date_consult ? $arrival_date_consult->format('Y-m-d H:i:s') : null;

if (count($errors) === 0) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE to_consult SET arrival_date_consult = :arrival_date_consult, price = :price, payment_method = :payment_method, anxiety_index = :anxiety_index, observations = :observations WHERE security_number = :security_number AND start_date_slot = :start_date_slot");

        $stmt->execute([
            ':start_date_slot' => $start_date_slot_mysql,
            ':arrival_date_consult' => $arrival_date_consult_mysql,
            ':price' => $_POST['price'],
            ':payment_method' => $_POST['payment_method'],
            ':anxiety_index' => $_POST['anxiety_index'],
            ':observations' => $_POST['observations'],
            ':security_number' => $_POST['security_number']
        ]);

        $success = "Consultation ajoutée avec succès.";
        $_SESSION['success'] = $success;
        header("Location: ../post-consult");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>

