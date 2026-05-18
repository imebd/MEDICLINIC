<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

if ($_SESSION['role'] !== 'admin') { header('Location: index.php'); exit(); }

$rdv_id = $_GET['rdv_id'] ?? null;
if (!$rdv_id) { die("Erreur : Aucun rendez-vous sélectionné."); }

$stmt = $pdo->prepare("SELECT r.*, p.nom, p.prenom FROM rendez_vous r JOIN patients p ON r.patient_id = p.id WHERE r.id = ?");
$stmt->execute([$rdv_id]);
$rdv = $stmt->fetch(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>
<h2 class="page-title">Nouvelle Consultation 🩺</h2>
<div class="form-card">
    <p><strong>Patient :</strong> <?= htmlspecialchars($rdv['nom'].' '.$rdv['prenom']) ?></p>
    <form action="store.php" method="POST">
        <input type="hidden" name="rendez_vous_id" value="<?= $rdv['id'] ?>">
        <div class="form-group">
            <label>Diagnostic</label>
            <textarea name="diagnostic" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Traitement</label>
            <textarea name="traitement" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>