<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'admin') { exit("Accès refusé"); }
require_once '../config/database.php';

$patient_id = $_POST['patient_id'] ?? null;
$medecin_id = $_POST['medecin_id'] ?? null;
$date_rdv = $_POST['date_rdv'] ?? null;
$heure_debut = $_POST['heure_debut'] ?? null;
$heure_fin = $_POST['heure_fin'] ?? null;
$motif = trim($_POST['motif'] ?? '');

if (!$patient_id || !$medecin_id || !$date_rdv || !$heure_debut || !$heure_fin) { die("Champs manquants"); }
if ($heure_fin <= $heure_debut) { die("Heure de fin invalide"); }

$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM rendez_vous WHERE medecin_id = :m AND date_rdv = :d AND heure_debut = :h AND statut != 'annulé'");
$stmtCheck->execute([':m'=>$medecin_id, ':d'=>$date_rdv, ':h'=>$heure_debut]);

if ($stmtCheck->fetchColumn() > 0) { die("Médecin indisponible"); }

$sql = "INSERT INTO rendez_vous (patient_id, medecin_id, date_rdv, heure_debut, heure_fin, motif, statut) VALUES (?, ?, ?, ?, ?, ?, 'programmé')";
$pdo->prepare($sql)->execute([$patient_id, $medecin_id, $date_rdv, $heure_debut, $heure_fin, $motif]);

header('Location: index.php');
exit;