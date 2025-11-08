<?php
require_once('../config/db.php'); // Inclure la connexion PDO
require_once('./email/sendMail.php');
require_once('./email/generCode.php');

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if ($username === "" || $password === "" || $email === "") {
	echo "Impossible de remplir avec le caractère espace ou champ vide";
	exit;
}

// Vérifier si l'utilisateur existe déjà
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->fetch()) {
	echo "Cet email est déjà utilisé.";
	exit;
}

$code = genereCode();

$stmt = $pdo->prepare("INSERT INTO temp_users (username, email, password_hash, code, expires_at)
                       VALUES (:username, :email, :password_hash, :code, DATE_ADD(NOW(), INTERVAL 15 MINUTE))");
$stmt->execute([
    'username' => $username,
    'email' => $email,
    'password_hash' => $hashedPassword,
    'code' => $code
]);

$tempId = $pdo->lastInsertId();
sendMail($email, $username, $code);
header("Location: ../pages/verif.html");


?>