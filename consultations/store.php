<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

if ($_SESSION['role'] !== 'admin') { exit("Accès refusé"); }

$rdv_id = $_POST['rendez_vous_id'] ?? null;
$diag = $_POST['diagnostic'] ?? '';
$traite = $_POST['traitement'] ?? '';

$stmtRdv = $pdo->prepare("SELECT * FROM rendez_vous WHERE id = ?");
$stmtRdv->execute([$rdv_id]);
$rdv = $stmtRdv->fetch();

if ($rdv) {
    // 1. Sauvegarde consultation [cite: 2026-03-21]
    $sql = "INSERT INTO consultations (rendez_vous_id, patient_id, medecin_id, date_consultation, diagnostic, traitement) 
            VALUES (?, ?, ?, NOW(), ?, ?)";
    $pdo->prepare($sql)->execute([$rdv['id'], $rdv['patient_id'], $rdv['medecin_id'], $diag, $traite]);

    // 2. Mise à jour statut RDV [cite: 2026-03-21]
    $pdo->prepare("UPDATE rendez_vous SET statut = 'terminé' WHERE id = ?")->execute([$rdv_id]);
}

header('Location: index.php');
exit;