<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Recupération des données
require_once 'user.php';

$pages = $_GET['pages'] ?? 'default';

$data = [];

switch ($pages) {
	case 'home':
		require_once './user.php';
		require_once __DIR__ . '/count/countTasks.php';
		require_once __DIR__ . '/count/countTasksComp.php';
		require_once __DIR__ .  '/count/countTasksEnCours.php';
		require_once __DIR__ .  '/count/CountTasksNotStart.php';
		require_once __DIR__ .  '/lastTask/lastTaskComplete.php';
		require_once __DIR__ .  '/lastTask/lastTaskInProgresse.php';
		require_once __DIR__ .  '/lastTask/lastTaskNotStarted.php';


		$user = getUser();
		$nbTasks = GetCount();
		$nbTasksCompleted= GetCountTasksCompleted();
		$nbTasksEnCours = GetCountTasksEnCours();
		$nbTaskNotStart = GetCountTasksNotStart();
		$lasTaskCompleted = getLastTaskCompete();
		$lastTaskInProgresse = getLastTaskInProgresse();
		$lastTaskNotStart = getlastTaskNotStart();


		$data =
		[
			"user" => $user,
			"stat" =>
			[
				"nbTasks"          => $nbTasks,
				"nbTaskNotStart"   => $nbTaskNotStart,
				"nbTasksEnCours"   => $nbTasksEnCours,
				"nbTasksCompleted" => $nbTasksCompleted
			],
			"lastTask" =>
			[
				"completed" => $lasTaskCompleted,
				"inProgresse" => $lastTaskInProgresse,
				"notStated" => $lastTaskNotStart,
				

			]
		];
		break;

	case 'tasks':
		require_once './count/countTasks.php';
		require_once './count/countTasksComp.php';


		$nbTasks = GetCount();
		$nbTasksCompleted= GetCountTasksCompleted();

		$data =
		[
			"stat" =>
			[
				"nbTasks" => $nbTasks,
				"nbTasksCompleted" => $nbTasksCompleted,
			]
		];
		break;


	//default:
	//    $data = ['message' => 'Page not found'];
}

echo json_encode($data);
?>