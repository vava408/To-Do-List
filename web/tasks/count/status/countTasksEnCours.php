<?php


require_once __DIR__ . '/../../../config/db.php';


require_once __DIR__ . '/countTasks.php';


function GetCountTasksEnCours()
{
	global $pdo;


	if(GetCount() != 0)
	{
		$stmt = $pdo->prepare(
			"SELECT COUNT(*) 
			FROM tasks 
			WHERE user_id = :user_id AND status = :status"
		);
		$stmt->execute
		([
			'user_id' => $_SESSION['user_id'],
			'status'  =>  'in_progress'
		]);
		$counbtEnCours = $stmt->fetchColumn();
		


		return $counbtEnCours ?: "Aucune tache n'est en cours" ;
	}
	return "Aucune taches n'est en cours";
}

?>