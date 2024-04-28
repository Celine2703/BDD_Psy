<?php

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

// Validation du numéro de sécurité sociale
if (isset($_POST['security_number'])) {
    $security_number = $_POST['security_number'];
    if (!preg_match('/^\d{13}$/', $security_number)) {
        $errors['security_number'] = "Le numéro de sécurité sociale doit contenir exactement 13 chiffres.";
    } else {
        // Vérification de l'unicité dans la base de données
        $stmt = $conn->prepare("SELECT COUNT(*) FROM patient WHERE security_number = :security_number");
        $stmt->bindParam(':security_number', $security_number);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $errors['security_number'] = "Ce numéro de sécurité sociale existe déjà.";
        }
    }
}

// Validation de l'email
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse e-mail n'est pas valide.";
    } else {
        // Vérification de l'unicité dans la base de données
        $stmt = $conn->prepare("SELECT COUNT(*) FROM patient WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }
    }
}


// Validation de la date de naissance
if (isset($_POST['date_naissance'])) {
    $date_naissance = $_POST['date_naissance'];
    if (new DateTime($date_naissance) > new DateTime()) {
        $errors['date_naissance'] = "La date de naissance doit être inférieure à aujourd'hui.";
    }
}

// Validation du téléphone
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    if (!preg_match('/^\d+$/', $phone)) {
        $errors['phone'] = "Le numéro de téléphone doit contenir uniquement des chiffres.";
    }
}

if (empty($_POST['lastname'])) {
    $errors['lastname'] = "Ce champ ne peut être vide.";
}

// Validation pour le prénom
if (empty($_POST['firstname'])) {
    $errors['firstname'] = "Ce champ ne peut être vide.";
}

// Validation pour le sexe
if (empty($_POST['sexe'])) {
    $errors['sexe'] = "Ce champ ne peut être vide.";
}

// Validation pour l'adresse
if (empty($_POST['adresse'])) {
    $errors['adresse'] = "Ce champ ne peut être vide.";
}

// Validation pour la date de naissance
if (empty($_POST['date_naissance'])) {
    $errors['date_naissance'] = "Ce champ ne peut être vide.";
}

return $errors;
?>
