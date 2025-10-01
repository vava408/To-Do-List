<?php
session_start();
require_once '../includes/utils.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    // Vérifier l'ancien mot de passe
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if (password_verify($current, $user['password'])) {
        // Mettre à jour le mot de passe
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['user_id']]);
        $message = "Mot de passe modifié avec succès.";
    } else {
        $message = "Mot de passe actuel incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le mot de passe</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>Modifier le mot de passe</h1>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <form method="post">
            <input type="password" name="current_password" placeholder="Mot de passe actuel" required>
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
            <button type="submit" class="edit-btn">Enregistrer</button>
        </form>
        <a href="../pages/profile.html" class="logout-btn">Retour au profil</a>
    </div>
</body>
</html>