<?php
session_start();


$title = trim($_POST['title']);
$date = trim($_POST['due_date']);
$status = trim($_POST['status']);
$description = trim($_POST['description']);

$datenow = new DateTime();
$userDate = new DateTime($date);

// Supprimer l'heure pour ne comparer que les dates
$datenow->setTime(0, 0, 0);
$userDate->setTime(0, 0, 0);

//echo "Date actuelle : " . $datenow->format('Y-m-d') . "<br>";
//echo "Date d'échéance : " . $userDate->format('Y-m-d') . "<br>";

if ($userDate == $datenow) {
	echo "La date d'échéance ne peut pas être celle du jour.";
	exit;
} elseif ($userDate < $datenow) {
	echo "La date d'échéance ne peut pas être dans le passé.";
	exit;
} else {
	echo "La date d'échéance est valide.";
	require_once('../config/db.php'); // Inclure la connexion PDO
	$stmt = $pdo->prepare(
		"SELECT id 
		FROM users 
		WHERE username = :username"
	);

	$stmt->execute([
		'username' => $_SESSION['user']
	]);

	$userId = $stmt->fetchColumn();

   //echo "ID de l'utilisateur : " . $userId . "<br>";

	if(!$userId) {
		echo "Utilisateur non trouvé.";
		exit;
	}

	$stmt = $pdo->prepare(
		"INSERT INTO tasks (title, description, due_date, status, user_id)
		VALUES (:title, :description, :due_date, :status, :user_id)");
	
	
	$stmt->execute([
		'title' => $title,
		'description' => $description,
		'due_date' => $date,
		'status' => $status,
		'user_id' => $userId
	]);

	echo "Tâche ajoutée avec succès.";
}
?>
