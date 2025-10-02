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
		require_once __DIR__ .  '/last-task/lastTaskComplete.php';

		$user = getUser();
		$nbTasks = GetCount();
		$nbTasksCompleted= GetCountTasksCompleted();
		$nbTasksEnCours = GetCountTasksEnCours();
		$nbTaskNotStart = GetCountTasksNotStart();
		$nbTasksCompleted = GetCountTasksCompleted();
		$lasTaskCompleted = getLastTaskCompete();

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
				"copleted" => $lasTaskCompleted
			]
		];
		break;

	case 'tasks':
		require_once 'user.php';
		require_once './count/countTasks.php';
		require_once './count/countTasksComp.php';

		$data['user'] = getUser();
		$data['nbTasks'] = GetCount();
		$data['nbTasksCompleted'] = GetCountTasksCompleted();
		break;


	//default:
	//    $data = ['message' => 'Page not found'];
}

echo json_encode($data);
?>