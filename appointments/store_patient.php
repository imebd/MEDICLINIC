<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'patient') { header('Location: index.php'); exit(); }
require_once '../config/database.php';

$id_utilisateur = $_SESSION['user_id'];
$medecin_id = $_POST['medecin_id'] ?? null;
$date_rdv = $_POST['date_rdv'] ?? null;
$heure_debut = $_POST['heure_debut'] ?? null;

$stmtPatient = $pdo->prepare("SELECT id FROM patients WHERE utilisateur_id = :uid");
$stmtPatient->execute([':uid' => $id_utilisateur]);
$patient = $stmtPatient->fetch();

if (!$patient || !$medecin_id) { die("Erreur : Données invalides."); }

$sql = "INSERT INTO rendez_vous (patient_id, medecin_id, date_rdv, heure_debut, statut) 
        VALUES (:pid, :mid, :drdv, :hdeb, 'en_attente')";

$pdo->prepare($sql)->execute([
    ':pid' => $patient['id'],
    ':mid' => $medecin_id,
    ':drdv' => $date_rdv,
    ':hdeb' => $heure_debut
]);

header('Location: index.php');
exit;
?>