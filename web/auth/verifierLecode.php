<?php
session_start();
require_once('../config/db.php');
require_once('./session.php');

header('Content-Type: application/json');

$codeInput = trim($_POST['code'] ?? '');

if ($codeInput === '') {
    echo json_encode(['error' => 'Veuillez entrer le code.']);
    exit;
}

if (!isset($_SESSION['pending_temp_id'])) {
    echo json_encode(['error' => 'Aucune inscription en attente.']);
    exit;
}

$tempId = $_SESSION['pending_temp_id'];

// Vérifie que le code est correct et non expiré
$stmt = $pdo->prepare("SELECT * FROM temp_users WHERE id = :id AND expires_at > NOW()");
$stmt->execute(['id' => $tempId]);
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$temp) {
    echo json_encode(['error' => 'Code expiré ou non trouvé.']);
    exit;
}

if ($temp['code'] !== $codeInput) {
    echo json_encode(['error' => 'Code incorrect.']);
    exit;
}

// Insère dans la table users
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at)
                           VALUES (:username, :email, :password, NOW())");
    $stmt->execute([
        'username' => $temp['username'],
        'email' => $temp['email'],
        'password' => $temp['password_hash']
    ]);

    $userId = $pdo->lastInsertId();

    // Supprime de temp_users
    $pdo->prepare("DELETE FROM temp_users WHERE id = :id")->execute(['id' => $tempId]);

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['error' => 'Erreur d\'insertion : ' . $e->getMessage()]);
    exit;
}

// Nettoyage et création de session utilisateur
session_unset();
session_destroy();
session_start();
sessionStart($temp['username'], $userId);

echo json_encode(['success' => 'Compte validé et connecté !']);
?>
