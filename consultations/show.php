<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$sql = "SELECT c.*, p.nom AS p_nom, p.prenom AS p_prenom, u.nom AS m_nom, u.prenom AS m_prenom 
        FROM consultations c
        JOIN patients p ON c.patient_id = p.id
        JOIN utilisateurs u ON c.medecin_id = u.id
        WHERE c.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$c = $stmt->fetch();

if (!$c) { die("Consultation introuvable."); }

require_once '../includes/header.php';
?>

<h2 class="page-title">Détails de la Consultation</h2>
<div class="form-card">
    <p><strong>Patient :</strong> <?= htmlspecialchars($c['p_nom'] . " " . $c['p_prenom']) ?></p>
    <p><strong>Médecin :</strong> Dr <?= htmlspecialchars($c['m_nom'] . " " . $c['m_prenom']) ?></p>
    <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($c['date_consultation'])) ?></p>
    <hr>
    <p><strong>Diagnostic :</strong><br><?= nl2br(htmlspecialchars($c['diagnostic'])) ?></p>
    <p><strong>Traitement :</strong><br><?= nl2br(htmlspecialchars($c['traitement'])) ?></p>
    <?php if(!empty($c['observations'])): ?>
        <p><strong>Observations :</strong><br><?= nl2br(htmlspecialchars($c['observations'])) ?></p>
    <?php endif; ?>
    <br>
    <a href="index.php" class="btn-view">Retour à la liste</a>
</div>

<?php require_once '../includes/footer.php'; ?>