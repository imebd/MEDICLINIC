<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) { die("Rendez-vous introuvable."); }

$sql = "SELECT r.*, p.nom AS p_nom, p.prenom AS p_prenom, p.telephone, u.nom AS m_nom, u.prenom AS m_prenom
        FROM rendez_vous r
        JOIN patients p ON r.patient_id = p.id
        JOIN utilisateurs u ON r.medecin_id = u.id
        WHERE r.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$rdv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rdv) { die("Rendez-vous introuvable."); }

require_once '../includes/header.php';
?>

<h2 class="page-title">Détails du Rendez-vous #<?= $rdv['id'] ?></h2>
<div class="form-card">
    <p><strong>Statut :</strong> <?= strtoupper($rdv['statut']) ?></p>
    <p><strong>Patient :</strong> <?= htmlspecialchars($rdv['p_nom'] . ' ' . $rdv['p_prenom']) ?></p>
    <p><strong>Téléphone :</strong> <?= htmlspecialchars($rdv['telephone']) ?></p>
    <p><strong>Médecin :</strong> Dr. <?= htmlspecialchars($rdv['m_nom'] . ' ' . $rdv['m_prenom']) ?></p>
    <hr>
    <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($rdv['date_rdv'])) ?></p>
    <p><strong>Heure :</strong> <?= htmlspecialchars($rdv['heure_debut']) ?></p>
    <p><strong>Motif :</strong><br><?= nl2br(htmlspecialchars($rdv['motif'])) ?></p>
    <br>
    <a href="index.php" class="btn-view">Retour</a>
</div>
<?php require_once '../includes/footer.php'; ?>