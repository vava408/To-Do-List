<?php
session_start();


	require_once('./../config/db.php');

	global $pdo;

	$username = trim($_POST['username']);


	//echo $_SESSION['user_id'];
	if(!isset($_SESSION['user_id']))
	{
		//echo 'non connecter';
		return;
	}

	$stmt = $pdo->prepare(
		"UPDATE users SET username = :username WHERE id = :user_id");



	$stmt->execute([
		'username' => $username,
		'user_id' => $_SESSION['user_id'],
	]);

	$userid = $_SESSION['user_id'];

	echo "Nom d'utilisateur changé avec succès. $username + $userid";
?>