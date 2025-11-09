<?php
session_start();
require_once('../config/db.php');
require_once('./email/sendMail.php');
require_once('./email/generCode.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === "" || $password === "" || $email === "") {
    echo "Veuillez remplir tous les champs correctement.";
    exit;
}

// Vérifie si l'email existe déjà
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->fetch()) {
    echo "Cet email est déjà utilisé.";
    exit;
}

// Génère un code aléatoire
$code = genereCode();
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Sauvegarde dans la table temporaire
$stmt = $pdo->prepare("INSERT INTO temp_users (username, email, password_hash, code, expires_at)
                       VALUES (:username, :email, :password_hash, :code, DATE_ADD(NOW(), INTERVAL 15 MINUTE))");
$stmt->execute([
    'username' => $username,
    'email' => $email,
    'password_hash' => $hashedPassword,
    'code' => $code
]);

// Enregistre l'ID temporaire en session
$_SESSION['pending_temp_id'] = $pdo->lastInsertId();

// Envoie l'email avec le code
sendMail($email, $username, $code);

// Redirection vers la page de vérification
header("Location: ../pages/verif.html");
exit;
?>
