<?php
	require_once __DIR__ . '/../config/db.php';


	function getDates()
	{
		global $pdo;

		//echo $_SESSION['user_id'];
		if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0 )
		{
			//echo 'non connecter';
			return "date";
		}
		$stmt = $pdo->prepare(
			"SELECT created_at 
			FROM users
			WHERE id = :id"
		);

		$stmt->execute([
			'id' => $_SESSION['user_id'],
		]);

		$created_at = $stmt->fetchColumn();

		//echo $mail['email'];
		return  $created_at;
	}

?>