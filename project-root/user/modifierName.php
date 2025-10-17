<?php
session_start();

	$username = trim($_POST['username']);

	require_once('./../config/db.php');

	global $pdo;

	//echo $_SESSION['user_id'];
	if(!isset($_SESSION['user_id']))
	{
		//echo 'non connecter';
		return $_SESSION['user_id'];
	}

	$stmt = $pdo->prepare(
		"UPDATE users SET username= :username WHERE id= :user_id");



	$stmt->execute([
		'username' => $username,
		'user_id' => $_SESSION['user_id']
	]);

	echo "Nom d'utilisateur changé avec succès.";
?>