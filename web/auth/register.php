<?php
require_once('../config/db.php'); // Inclure la connexion PDO
require_once('verifyEmal.php');

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

//verifie la validité de l'email
if(!getEmailValide($email))
{
	echo "Erreur dans le mail";
}
else
{
	echo "ok";


	// Hasher le mot de passe
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
	// Insérer dans la base
	$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
	try {
		$stmt->execute([
			'username' => $username,
			'email' => $email,
			'password' => $hashedPassword
		]);
		echo "Inscription réussie !";
		header("Location: ../pages/login.html");
	
	} catch (PDOException $e) {
		echo "Erreur lors de l'inscription : " . $e->getMessage();
	}
}
?>