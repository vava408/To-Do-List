<?php
session_start();
// Inclure la connexion à la base de données
require_once '../includes/utils.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.html');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = trim($_POST['username']);
    // Mettre à jour le nom dans la base de données
    // Exemple avec PDO :
    $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->execute([$newName, $_SESSION['user_id']]);
    $_SESSION['username'] = $newName;
    $message = "Nom d'utilisateur modifié avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le nom d'utilisateur</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>Modifier le nom d'utilisateur</h1>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <form method="post">
            <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
            <button type="submit" class="edit-btn">Enregistrer</button>
        </form>
        <a href="../pages/profile.html" class="logout-btn">Retour au profil</a>
    </div>
</body>
</html>