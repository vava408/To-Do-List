<?php
session_start();
header('Content-Type: application/json');
require_once('../config/db.php');


// Empêcher toute sortie avant JSON
ob_start();

$title = trim($_POST['title']);
$date = trim($_POST['due_date']);
$status = trim($_POST['status']);
$description = trim($_POST['description']);
$priority = trim($_POST['priority']);

$datenow = new DateTime();
$userDate = new DateTime($date);

// Supprimer l'heure
$datenow->setTime(0, 0, 0);
$userDate->setTime(0, 0, 0);

// Vérifications des dates
if ($userDate == $datenow) {
    echo json_encode(["error" => "La date d'échéance ne peut pas être celle du jour."]);
    exit;
} elseif ($userDate < $datenow) {
    echo json_encode(["error" => "La date d'échéance ne peut pas être dans le passé."]);
    exit;
}


// Récupérer l'user ID
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
$stmt->execute(['username' => $_SESSION['user']]);
$userId = $stmt->fetchColumn();

if (!$userId) {
    echo json_encode(["error" => "Utilisateur non trouvé."]);
    exit;
}

switch ($priority) {
	case 'Importante':
		$priorityLevel = 1;
		break;
	case 'Moyenne':
		$priorityLevel = 2;
		break;
	case 'Faible':
		$priorityLevel = 3;
		break;
	default:
		echo json_encode(["error" => "Priorité invalide."]);
		exit;
}

// Insérer la tâche
$stmt = $pdo->prepare(
    "INSERT INTO tasks (title, description, due_date, status, user_id, priority)
     VALUES (:title, :description, :due_date, :status, :user_id, :priority)"
);

$stmt->execute([
    'title' => $title,
    'description' => $description,
    'due_date' => $date,
    'status' => $status,
    'user_id' => $userId,
	'priority' => $priorityLevel
]);

// ✅ Réponse JSON au lieu d'une redirection
echo json_encode(["success" => "Tâche ajoutée avec succès !"]);
exit;
