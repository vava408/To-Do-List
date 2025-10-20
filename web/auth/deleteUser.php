<?php 

	require_once __DIR__ . '/../config/db.php';

	global $pdo;

		session_start();

		if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0)
		{
			//echo 'non connecter';
			header("Location: ../pages/login.html");
			exit();
		}
		
		$stmt = $pdo->prepare(
			"DELETE FROM users
			WHERE id = :id"
		);

		$stmt->execute([
			'id' => $_SESSION['user_id'],
		]);

		session_destroy();
		header("Location: ../pages/home.html");
		exit();
	

?>