<?php
session_start();
require_once('../config/db.php');
require_once('./session.php');

header('Content-Type: application/json; charset=utf-8');

$codeInput = trim($_POST['code'] ?? '');
if ($codeInput === '') { echo json_encode(['error'=>'Veuillez entrer le code']); exit; }

if (!isset($_SESSION['pending_temp_id'])) {
    echo json_encode(['error'=>'Aucune inscription en attente']); exit;
}

$tempId = (int) $_SESSION['pending_temp_id'];

$stmt = $pdo->prepare("SELECT * FROM temp_users WHERE id=:id AND expires_at>NOW()");
$stmt->execute(['id'=>$tempId]);
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$temp) { echo json_encode(['error'=>'Code expiré ou non trouvé']); exit; }
if ((string)$temp['code'] !== (string)$codeInput) { echo json_encode(['error'=>'Code incorrect']); exit; }

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO users (username,email,password,created_at)
        VALUES (:username,:email,:password,NOW())");
    $stmt->execute([
        'username'=>$temp['username'],
        'email'=>$temp['email'],
        'password'=>$temp['password_hash']
    ]);
    $userId = $pdo->lastInsertId();
    $pdo->prepare("DELETE FROM temp_users WHERE id=:id")->execute(['id'=>$tempId]);
    $pdo->commit();
} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(['error'=>'Erreur DB: '.$e->getMessage()]);
    exit;
}

unset($_SESSION['pending_temp_id']);
sessionStart($temp['username'],$userId);

echo json_encode(['success'=>'Compte validé et connecté !']);
exit;
?>
