<?php
$host = "mysql-airbot.alwaysdata.net";
$dbname = "airbot_siteperso";
$username = "airbot";     // ton utilisateur Alwaysdata
$password = "vava11ba"; // ton mot de passe Alwaysdata

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Active le mode exception pour gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie !"; // debug
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
