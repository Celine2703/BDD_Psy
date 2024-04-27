<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("loadEnv.php");
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $dbname = $_ENV['DB_NAME'];

    try {
        // Supposons que $errors est un tableau renvoyé par votre validateur
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        $errors = include('./slot_validator.php'); // Assurez-vous que ce fichier existe et renvoie bien un tableau

        if (count($errors) == 0) {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $date = $_POST['date'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];

            $start = new DateTime("$date $start_time");
            $end = new DateTime("$date $end_time");

            while ($start < $end) {
                $end_slot = clone $start;
                $end_slot->modify('+30 minutes');

                if ($end_slot > $end) {
                    break;
                }

                $start_datetime = $start->format('Y-m-d H:i:s');
                $sql = "INSERT INTO slot (start_date_slot) VALUES (:start_datetime)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':start_datetime', $start_datetime);
                $stmt->execute();

                $start->modify('+30 minutes'); // Move to next slot
            }

            echo "Slots ajoutés avec succès.";
            header("Location: ./slot");
            exit();
        } else {
            // Gérez l'affichage des erreurs ici
            foreach ($errors as $error) {
                echo "<p>Error: $error</p>";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
