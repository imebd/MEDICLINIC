<?php
require_once '../includes/auth.php';

// AJOUT DE LA SÉCURITÉ : Seul l'admin peut modifier le statut d'une facture
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$statut = $_GET['statut'] ?? null;

if (!$id || !$statut) {
    die("Informations invalides.");
}

if ($statut !== 'payée' && $statut !== 'non_payée') {
    die("Statut invalide.");
}

$stmt = $pdo->prepare("UPDATE factures SET statut_paiement = :statut WHERE id = :id");
$stmt->execute([
    ':statut' => $statut,
    ':id' => $id
]);

header('Location: index.php');
exit;
?>