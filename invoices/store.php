<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'admin') { die("Accès refusé."); }

require_once '../config/database.php';

$consultation_id = $_POST['consultation_id'] ?? null;
$montant = $_POST['montant'] ?? null;
$statut_paiement = $_POST['statut_paiement'] ?? 'non_payée';

if (!$consultation_id || !$montant) { die("Données incomplètes."); }

// Ton code original de vérification d'existence [cite: 2026-03-21]
$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM factures WHERE consultation_id = :id");
$stmtCheck->execute([':id' => $consultation_id]);

if ($stmtCheck->fetchColumn() > 0) {
    die("Une facture existe déjà pour cette consultation.");
}

$sql = "INSERT INTO factures (consultation_id, montant, statut_paiement, date_facture)
        VALUES (:id, :m, :s, CURDATE())";

$pdo->prepare($sql)->execute([
    ':id' => $consultation_id,
    ':m' => $montant,
    ':s' => $statut_paiement
]);

header('Location: index.php');
exit;