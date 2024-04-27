<?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$errors = [];

// Validation de la date
if (!empty($_POST['date'])) {
    $date = $_POST['date'];
    $currentDate = new DateTime(); // date actuelle
    $currentDate->setTime(0, 0, 0); // réinitialiser l'heure pour la comparaison de jour uniquement
    $inputDate = new DateTime($date);

    if ($inputDate < $currentDate) {
        $errors['date'] = "La date doit être supérière à celle d'aujourd'hui.";
    }
} else {
    $errors['date'] = "Ce champ est requis.";
}


// Validation de la combinaison date + heure de début
if (!empty($_POST['date']) && !empty($_POST['start_time']) && !empty($_POST['end_time'])) {
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $start_datetime = new DateTime("$date $start_time");
    $end_datetime = new DateTime("$date $end_time");
    $formatted_start_datetime = $start_datetime->format('Y-m-d H:i:s');
    $formatted_end_datetime = $end_datetime->format('Y-m-d H:i:s');

    // Assurez-vous que l'heure de fin est après l'heure de début
    if ($end_datetime <= $start_datetime) {
        $errors['end_datetime'] = "L'heure de fin doit être postérieure à l'heure de début.";
    }

    // Vérification de l'unicité dans la base de données pour l'heure de début
    $sql = "SELECT COUNT(*) FROM slot WHERE start_date_slot = :start_datetime";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':start_datetime', $formatted_start_datetime);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $errors['start_datetime'] = "Ce créneau est déjà réservé.";
    }
}

?>