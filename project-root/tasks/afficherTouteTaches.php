<?php

require_once __DIR__ . '/../config/db.php';

function getTouteTask()
{
	global $pdo;

	if (!isset($_SESSION['user_id'])) {
		return "Aucune tache";
	}

	$stmt = $pdo->prepare(
		"SELECT title, due_date, status 
		FROM tasks 
		WHERE user_id = :user_id  
		ORDER BY due_date AND status DESC"
	);

	$stmt->execute([
		'user_id' => $_SESSION['user_id'],
	]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // renvoie un tableau associatif

}
