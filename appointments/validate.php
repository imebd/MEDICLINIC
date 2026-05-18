<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Sécurité : Vérifier que c'est bien l'admin ou la secrétaire
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'secretaire') {
    die("Accès non autorisé.");
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null; // 'confirmé' ou 'annulé'

if ($id && $action) {
    $stmt = $pdo->prepare("UPDATE rendez_vous SET statut = :statut WHERE id = :id");
    $stmt->execute(['statut' => $action, 'id' => $id]);
}

// Redirection vers la liste
header("Location: index.php");
exit;