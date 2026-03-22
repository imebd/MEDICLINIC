<?php
require_once '../config/database.php';
$patients = $pdo->query("SELECT id, nom, prenom FROM patients")->fetchAll();
$medecins = $pdo->query("SELECT id, nom FROM utilisateurs WHERE role='medecin'")->fetchAll();
include '../includes/header.php';
?>
<div class="container">
    <h2>Prendre un Rendez-vous</h2>
    <form action="store.php" method="POST">
        <label>Patient :</label>
        <select name="patient_id">
            <?php foreach($patients as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['nom'] ?> <?= $p['prenom'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Médecin :</label>
        <select name="medecin_id">
            <?php foreach($medecins as $m): ?>
                <option value="<?= $m['id'] ?>">Dr. <?= $m['nom'] ?></option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="date_rdv" required>
        <input type="time" name="heure_debut" required>
        <textarea name="motif" placeholder="Motif de la visite..."></textarea>
        
        <button type="submit">Enregistrer</button>
    </form>
</div>