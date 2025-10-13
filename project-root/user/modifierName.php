<?php

	require_once __DIR__ . '/../config/db.php';

	global $pdo;

	//echo $_SESSION['user_id'];
	if(!isset($_SESSION['user_id']))
	{
		//echo 'non connecter';
		return $_SESSION['user_id'];
	}

	$stmt = $pdo->prepare(
		"SELECT username
		FROM users
		WHERE id = :id"
	);

	$stmt->execute([
		'id' => $_SESSION['user_id'],
	]);

	$mail = $stmt->fetchColumn();

?>

