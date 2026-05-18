<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Récupérer la liste des médecins pour le sélecteur
$medecins = $pdo->query("SELECT id, nom, prenom FROM utilisateurs WHERE role = 'medecin' AND actif = 1")->fetchAll();

require_once '../includes/header.php';
?>

<h2 class="page-title">Demander un rendez-vous</h2>

<div class="form-card">
    <form action="store_patient.php" method="POST">
        <div class="form-group">
            <label>Choisir un médecin</label>
            <select name="medecin_id" class="form-control" required>
                <?php foreach ($medecins as $m): ?>
                    <option value="<?= $m['id'] ?>">Dr. <?= htmlspecialchars($m['nom'].' '.$m['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date souhaitée</label>
            <input type="date" name="date_rdv" class="form-control" required min="<?= date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <label>Heure</label>
            <input type="time" name="heure_debut" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>