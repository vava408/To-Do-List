<?php
require_once __DIR__ . '/../config/db.php';

	function getTaskById($id)
	{
		global $pdo;
		
		if ($id == null) {
			$data = ["message" => "Erreur: id manquant"];
			return $data;
		}

			$stmt = $pdo->prepare(
			"SELECT * 
			FROM tasks 
			WHERE id = :task_id 
			AND user_id = :user_id"
		);

		$stmt->execute([
			'user_id' => $_SESSION['user_id'],
			'task_id' => $id
		]);

		$task = $stmt->fetch(PDO::FETCH_ASSOC);

		return $task ?? "Aucune tâche terminée";
	}

?>