<?php
require_once('../config/db.php'); // Inclure la connexion PDO
require_once('../includes/session.php');

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if ($email === "" || $password === "") {
    echo "Impossible de remplir avec le caractère espace ou champ vide";
    exit;
}

// Vérifier si l'utilisateur existe
$stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur non trouvé";
    exit;
}

// Vérifier le mot de passe
if (!password_verify($password, $user['password'])) {
    echo "Mot de passe incorrect";
    exit;
}

// Authentification réussie
$userName = $user['username'];
$userId = $user['id'];
sessionStart($userName, $userId);


require_once('../includes/session.php');
//echo "Connexion réussie. Bienvenue, utilisateur : " . $_SESSION['user'];
header("Location: ../pages/home.html");
exit;
?>