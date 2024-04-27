<?php
include("loadEnv.php");

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try
{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $security_number = $_POST['security_number'];
        $email = $_POST['email'];

        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM patient WHERE security_number = :security_number OR email = :email");
        $checkStmt->bindParam(':security_number', $security_number);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0)
        {
            $error_message = "Le numéro de sécurité sociale ou l'email existe déjà.";
        }
        else
        {
            $firstname = $_POST['firstname'];
            $second_name = $_POST['second_name'];
            $lastname = $_POST['lastname'];
            $sex = $_POST['sexe'];
            $born_date = $_POST['date_naissance'];
            $phone = $_POST['phone'];

            $stmt = $conn->prepare("INSERT INTO patient (security_number, firstname, second_name, lastname, sex, born_date, known_by, email, phone) 
                                    VALUES (:security_number, :firstname, :second_name, :lastname, :sex, :born_date, 'ajouté via formulaire', :email, :phone)");
            $stmt->bindParam(':security_number', $security_number);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':second_name', $second_name);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':born_date', $born_date);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();

            echo "Patient ajouté avec succès.";
            header("Location: ./patient");
            exit();
        }
    }
}
catch(PDOException $e)
{
    echo "Erreur : " . $e->getMessage();
}
$conn = null;
?>
