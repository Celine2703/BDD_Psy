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

if (!empty($_POST['arrival_date_consult']) && DateTime::createFromFormat('Y-m-d H:i:s', $_POST['arrival_date_consult']) === false) {
    $errors['arrival_date_consult'] = "Le format de la date d'arrivée n'est pas valide.";
}

if (count($errors) === 0) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO to_consult (start_date_slot, arrival_date_consult, price, payment_method, anxiety_index, observations, security_number) VALUES (:start_date_slot, :arrival_date_consult, :price, :payment_method, :anxiety_index, :observations, :security_number)");

        $stmt->execute([
            ':start_date_slot' => $_POST['start_date_slot'],
            ':arrival_date_consult' => $_POST['arrival_date_consult'],
            ':price' => $_POST['price'],
            ':payment_method' => $_POST['payment_method'],
            ':anxiety_index' => $_POST['anxiety_index'],
            ':observations' => $_POST['observations'],
            ':security_number' => $_POST['security_number']
        ]);

        $success = "Consultation ajoutée avec succès.";
        $_SESSION['success'] = $success;
        header("Location: ./post-consult");
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

