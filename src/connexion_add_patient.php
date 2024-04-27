<?php

include("loadEnv.php");

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $security_number = $_POST['security_number'];
        $firstname = $_POST['firstname'];
        $second_name = $_POST['second_name'];
        $lastname = $_POST['lastname'];
        $sex = $_POST['sexe'];
        $born_date = $_POST['date_naissance'];

        $stmt = $conn->prepare("INSERT INTO patient (security_number, firstname, second_name, lastname, sex, born_date, known_by) 
                                VALUES (:security_number, :firstname, :second_name, :lastname, :sex, :born_date, 'ajouté via formulaire')");
        $stmt->bindParam(':security_number', $security_number);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':second_name', $second_name);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':born_date', $born_date);
        $stmt->execute();

    }
}
catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


$conn = null;
?>

<script>
// Réinitialiser le formulaire une fois soumis avec succès

$("#form_add_patient").submit(function(event) {
    // location.reload();
});
</script>