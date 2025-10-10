<?php
	require_once __DIR__ . '/../config/db.php';


	function getMail()
	{
		global $pdo;

		//echo $_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			//echo 'non connecter';
			return $_SESSION['user_id'];
		}
		$stmt = $pdo->prepare(
			"SELECT email 
			FROM users
			WHERE id = :id"
		);

		$stmt->execute([
			'id' => $_SESSION['user_id'],
		]);

		$mail = $stmt->fetchColumn();

		//echo $mail['email'];
		return  $mail;
	}

?>