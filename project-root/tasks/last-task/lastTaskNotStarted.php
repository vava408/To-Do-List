<?php

require_once __DIR__ . '/../../config/db.php';

function getLastTaskNotStart()
{
	global $pdo;

	if (!isset($_SESSION['user_id'])) {
		return "Aucune tache terminer";
	}

	$stmt = $pdo->prepare(
		"SELECT title, updated_at, status 
		FROM tasks 
		WHERE user_id = :user_id  
		AND status = :status 
		ORDER BY updated_at DESC"
	);

	$stmt->execute([
		'user_id' => $_SESSION['user_id'],
		'status'  => "not_started"
	]);

	$task = $stmt->fetch(PDO::FETCH_ASSOC);

	return $task['title'] ?? "Aucune tâche terminée";
}
