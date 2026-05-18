<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'admin') { exit("Accès refusé"); }
require_once '../config/database.php';

$id = $_POST['id'] ?? null;
$patient_id = $_POST['patient_id'] ?? null;
$medecin_id = $_POST['medecin_id'] ?? null;
$date_rdv = $_POST['date_rdv'] ?? null;
$heure_debut = $_POST['heure_debut'] ?? null;
$heure_fin = $_POST['heure_fin'] ?? null;
$motif = trim($_POST['motif'] ?? '');

$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM rendez_vous WHERE medecin_id = :m AND date_rdv = :d AND heure_debut = :h AND statut != 'annulé' AND id != :id");
$stmtCheck->execute([':m'=>$medecin_id, ':d'=>$date_rdv, ':h'=>$heure_debut, ':id'=>$id]);

if ($stmtCheck->fetchColumn() > 0) { die("Médecin indisponible"); }

$sql = "UPDATE rendez_vous SET patient_id=?, medecin_id=?, date_rdv=?, heure_debut=?, heure_fin=?, motif=? WHERE id=?";
$pdo->prepare($sql)->execute([$patient_id, $medecin_id, $date_rdv, $heure_debut, $heure_fin, $motif, $id]);

header('Location: index.php');
exit;