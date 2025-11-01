<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$data = [];

try {
	// Inclusion du fichier user
	require_once __DIR__ . '/../user/user.php';
	$user = getUser();


	$pages = $_GET['pages'] ?? 'default';

	switch ($pages) {
		case 'home':
			require_once __DIR__ . '/../tasks/count/countTasks.php';
			require_once __DIR__ . '/../tasks/count/countTasksComp.php';
			require_once __DIR__ . '/../tasks/count/countTasksEnCours.php';
			require_once __DIR__ . '/../tasks/count/CountTasksNotStart.php';
			require_once __DIR__ . '/../tasks/lastTask/lastTaskComplete.php';
			require_once __DIR__ . '/../tasks/lastTask/lastTaskInProgresse.php';
			require_once __DIR__ . '/../tasks/lastTask/lastTaskNotStarted.php';

			$nbTasks = GetCount();
			$nbTasksCompleted = GetCountTasksCompleted();
			$nbTasksEnCours = GetCountTasksEnCours();
			$nbTaskNotStart = GetCountTasksNotStart();
			$lastTaskCompleted = getLastTaskCompete();
			$lastTaskInProgresse = getLastTaskInProgresse();
			$lastTaskNotStart = getLastTaskNotStart();

			$data = [
				"user" => $user,
				"stat" => [
					"nbTasks" => $nbTasks,
					"nbTaskNotStart" => $nbTaskNotStart,
					"nbTasksEnCours" => $nbTasksEnCours,
					"nbTasksCompleted" => $nbTasksCompleted
				],
				"lastTask" => [
					"completed" => $lastTaskCompleted,
					"inProgresse" => $lastTaskInProgresse,
					"notStated" => $lastTaskNotStart,
				]
			];
			break;

		case 'tasks':
			require_once __DIR__ . '/../tasks/count/countTasks.php';
			require_once __DIR__ . '/../tasks/count/countTasksComp.php';
			require_once __DIR__ . '/../tasks/afficherTache.php';

			$nbTasks = GetCount();
			$nbTasksCompleted = GetCountTasksCompleted();
			$task = getTask();

			$data = [
				"user" => $user,
				"stat" => [
					"nbTasks" => $nbTasks,
					"nbTasksCompleted" => $nbTasksCompleted,
				],
				"task" => $task,
			];
			break;

		case 'mesTasks':
			require_once __DIR__ . '/../tasks/afficherTouteTaches.php';

			$allTask = getTouteTask();
			$data = ["mesTasks" => $allTask];
			break;

		case 'profile' : 
			require_once __DIR__ . '/../user/mail.php';
			require_once __DIR__ . '/../user/dateCompte.php';
			require_once __DIR__ . '/../tasks/count/countTasks.php';
			require_once __DIR__ . '/../tasks/count/countTasksComp.php';
			require_once __DIR__ . '/../tasks/count/countTasksEnCours.php';



			$mail = getMail();
			$date = getDates();
			$nbTasks = GetCount();
			$nbTasksCompleted = GetCountTasksCompleted();
			$nbTasksEnCours = GetCountTasksEnCours();



			$data = [
				"user" => $user,
				"mail" => $mail,
				"date" => $date,
 				"nbTasks" => $nbTasks,
				"nbTasksCompleted" => $nbTasksCompleted,
				"nbTasksEnCours" => $nbTasksEnCours,
			];
			
			break;
		default:
			$data = ["message" => "Page not found"];
	}

} catch (Exception $e) {
	$data = ["error" => $e->getMessage()];
}

echo json_encode($data);
?>
