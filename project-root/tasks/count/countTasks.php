<?php
//session_start();
require_once __DIR__ . '/../../config/db.php';


function GetCount()
{
    global $pdo;    

    if (!isset($_SESSION['user_id'])) {
        return 0; // Retourne 0 si l'utilisateur n'est pas connecté

    }
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $count = $stmt->fetchColumn();

    return $count ?: 0; // Retourne 0 si aucune tâche n'est trouvée

}

?>