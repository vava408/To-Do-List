<?php
session_start();
header('Content-Type: application/json');
require_once('../config/db.php');

// Empêcher toute sortie avant JSON
ob_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo json_encode(["error" => "Utilisateur non connecté."]);
    exit;
}

// Récupérer les données du formulaire
$taskId = trim($_POST['task_id'] ?? '');
$title = trim($_POST['title'] ?? '');
$date = trim($_POST['due_date'] ?? '');
$status = trim($_POST['status'] ?? '');
$description = trim($_POST['description'] ?? '');
$priority = trim($_POST['priority'] ?? '');

// Validation des champs
if (empty($taskId) || empty($title) || empty($date) || empty($status) || empty($description) || empty($priority)) {
    echo json_encode(["error" => "Tous les champs sont requis."]);
    exit;
}

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

// Vérifier que la tâche appartient bien à l'utilisateur
$stmt = $pdo->prepare("SELECT id FROM tasks WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $taskId, 'user_id' => $userId]);

if (!$stmt->fetchColumn()) {
    echo json_encode(["error" => "Tâche non trouvée ou vous n'avez pas les droits."]);
    exit;
}

// Conversion de la priorité
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

// Mettre à jour la tâche
$stmt = $pdo->prepare(
    "UPDATE tasks 
     SET title = :title, 
         description = :description, 
         due_date = :due_date, 
         status = :status, 
         priority = :priority 
     WHERE id = :id AND user_id = :user_id"
);

$result = $stmt->execute([
    'title' => $title,
    'description' => $description,
    'due_date' => $date,
    'status' => $status,
    'priority' => $priorityLevel,
    'id' => $taskId,
    'user_id' => $userId
]);

if ($result) {
    echo json_encode(["success" => "Tâche mise à jour avec succès !"]);
} else {
    echo json_encode(["error" => "Erreur lors de la mise à jour de la tâche."]);
}
exit;
