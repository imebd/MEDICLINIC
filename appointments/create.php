<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'admin') { header('Location: index.php'); exit(); }
require_once '../config/database.php';

$patients = $pdo->query("SELECT id, nom, prenom FROM patients ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
$medecins = $pdo->query("SELECT id, nom, prenom, specialite FROM utilisateurs WHERE role = 'medecin' AND actif = 1 ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>
<h2 class="page-title">Ajouter un rendez-vous</h2>
<div class="form-card">
    <form action="store.php" method="POST">
        <div class="form-group">
            <label>Patient</label>
            <select name="patient_id" class="form-control" required>
                <option value="">Choisir un patient</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?= $patient['id'] ?>"><?= htmlspecialchars($patient['nom'].' '.$patient['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Médecin</label>
            <select name="medecin_id" class="form-control" required>
                <option value="">Choisir un médecin</option>
                <?php foreach ($medecins as $medecin): ?>
                    <option value="<?= $medecin['id'] ?>">Dr <?= htmlspecialchars($medecin['nom'].' '.$medecin['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Date</label><input type="date" name="date_rdv" class="form-control" required></div>
        <div class="form-group"><label>Début</label><input type="time" name="heure_debut" class="form-control" required></div>
        <div class="form-group"><label>Fin</label><input type="time" name="heure_fin" class="form-control" required></div>
        <div class="form-group"><label>Motif</label><textarea name="motif" class="form-control"></textarea></div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>