<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'admin') { exit("Accès refusé"); }
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("UPDATE rendez_vous SET statut = 'annulé' WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;