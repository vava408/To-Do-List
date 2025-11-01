<?php
session_start();
header('Content-Type: application/json');

// Empêcher toute sortie avant JSON
ob_start();

$title = trim($_POST['title']);
$date = trim($_POST['due_date']);
$status = trim($_POST['status']);
$description = trim($_POST['description']);

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

require_once('../config/db.php');

// Récupérer l'user ID
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
$stmt->execute(['username' => $_SESSION['user']]);
$userId = $stmt->fetchColumn();

if (!$userId) {
    echo json_encode(["error" => "Utilisateur non trouvé."]);
    exit;
}

// Insérer la tâche
$stmt = $pdo->prepare(
    "INSERT INTO tasks (title, description, due_date, status, user_id)
     VALUES (:title, :description, :due_date, :status, :user_id)"
);

$stmt->execute([
    'title' => $title,
    'description' => $description,
    'due_date' => $date,
    'status' => $status,
    'user_id' => $userId
]);

// ✅ Réponse JSON au lieu d'une redirection
echo json_encode(["success" => "Tâche ajoutée avec succès !"]);
exit;
