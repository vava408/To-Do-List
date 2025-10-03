<?php

require_once __DIR__ . '/../config/db.php';

function getTask()
{
	global $pdo;

	if (!isset($_SESSION['user_id'])) {
		return "Aucune tache terminer";
	}

	$stmt = $pdo->prepare(
		"SELECT title, due_date, status 
		FROM tasks 
		WHERE user_id = :user_id  
		ORDER BY due_date DESC
		LIMIT 20"
	);

	$stmt->execute([
		'user_id' => $_SESSION['user_id'],
	]);

	$task = $stmt->fetch(PDO::FETCH_ASSOC);

	return $task ?? "Aucune tâche terminée";
}
