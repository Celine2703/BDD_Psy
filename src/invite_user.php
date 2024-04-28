<?php
include_once("loadEnv.php");
loadEnv();

$message = "";
$password = "";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $connData = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $connData->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtData = $connData->prepare("SELECT email FROM patient WHERE security_number = ?");
    $stmtData->bindParam(1, $_GET['id']);
    $stmtData->execute();
    $email = $stmtData->fetchColumn();

    if (!$email) {
        $message = "Email non trouvé pour le numéro de sécurité.";
    } else {
        $connUser = new PDO("mysql:host=" . $_ENV['DB_C_HOST'] . ";dbname=" . $_ENV['DB_C_NAME'], $_ENV['DB_C_USER'], $_ENV['DB_C_PASS']);
        $connUser->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Générer un mot de passe aléatoire
        $password = bin2hex(random_bytes(4)); // 8 characters long
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Vérifie si l'utilisateur existe déjà et met à jour ou crée un nouveau utilisateur
        $stmtCheckUser = $connUser->prepare("SELECT security_number FROM users WHERE security_number = ?");
        $stmtCheckUser->execute([$_GET['id']]);
        if ($stmtCheckUser->fetch()) {
            $stmtUpdateUser = $connUser->prepare("UPDATE users SET password = ?, role = 'user' WHERE security_number = ?");
            $stmtUpdateUser->execute([$passwordHash, $_GET['id']]);
            $message = "Mot de passe de l'utilisateur mis à jour avec succès.";
        } else {
            $stmtUser = $connUser->prepare("INSERT INTO users (security_number, password, role) VALUES (?, ?, 'user')");
            $stmtUser->execute([$_GET['id'], $passwordHash]);
            $message = "Utilisateur créé avec succès.";
        }

        // Envoi d'email
        $headers = 'From: your-email@example.com';
        if (mail($email, "Invitation à vous connecter", "Votre identifiant : " . $_GET['id'] . "\nVotre mot de passe : " . $password, $headers)) {
            $message .= " Email envoyé avec succès.";
        } else {
            $message .= " Erreur lors de l'envoi de l'email.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitation à vous connecter</title>
    <?php include './includes.html'; ?>
</head>
<body>
<?php include './header.php'; ?>

<div class="container mt-5 mb-5">
    <h4 class="mb-3">Inviter un utilisateur</h4>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" action="inviteUser.php">
        <div class="form-group">
            <label for="id">Numéro de sécurité:</label>
            <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe généré:</label>
            <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>" disabled>
        </div>
    </form>
</div>

<?php include './end.html'; ?>
<?php include './include_js.html'; ?>
</body>
</html>
