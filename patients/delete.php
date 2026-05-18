<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Patient introuvable.");
}

$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM rendez_vous WHERE patient_id = :id");
$stmtCheck->execute([':id' => $id]);
$nbRdv = $stmtCheck->fetchColumn();

if ($nbRdv > 0) {
    die("Suppression impossible : ce patient possède déjà des rendez-vous.");
}

$stmtDelete = $pdo->prepare("DELETE FROM patients WHERE id = :id");
$stmtDelete->execute([':id' => $id]);

header('Location: index.php');
exit;
?>