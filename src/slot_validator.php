<?php

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

// Validation de l'email avec correction
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse e-mail n'est pas valide.";
    } else {
        // Préparation de la requête et liaison de la variable
        $stmt = $conn->prepare("SELECT COUNT(*) FROM patient WHERE email = :email");
        $stmt->bindParam(':email', $email); // Liaison de la variable, non de la valeur directement
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }
    }
}

// Correction pour les autres utilisations de bindParam pour éviter les erreurs futures
if (isset($_POST['security_number'])) {
    $security_number = $_POST['security_number'];
    if (!preg_match('/^\d{13}$/', $security_number)) {
        $errors['security_number'] = "Le numéro de sécurité sociale doit contenir exactement 13 chiffres.";
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM patient WHERE security_number = :security_number");
        $stmt->bindParam(':security_number', $security_number);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $errors['security_number'] = "Ce numéro de sécurité sociale existe déjà.";
        }
    }
}

return $errors;
?>
