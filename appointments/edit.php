<?php
require_once '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'] ?? null;

// 1. On récupère le RDV actuel
$stmt = $pdo->prepare("SELECT * FROM rendez_vous WHERE id = ?");
$stmt->execute([$id]);
$rdv = $stmt->fetch();

if (!$rdv) die("Rendez-vous introuvable.");

// 2. On récupère les listes pour les menus déroulants
$patients = $pdo->query("SELECT id, nom, prenom FROM patients")->fetchAll();
$medecins = $pdo->query("SELECT id, nom FROM utilisateurs WHERE role='medecin'")->fetchAll();
?>

<div class="container">
    <h2>Modifier le Rendez-vous</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $rdv['id'] ?>">

        <label>Patient :</label>
        <select name="patient_id">
            <?php foreach($patients as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $rdv['patient_id'] ? 'selected' : '' ?>>
                    <?= $p['nom'] ?> <?= $p['prenom'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Médecin :</label>
        <select name="medecin_id">
            <?php foreach($medecins as $m): ?>
                <option value="<?= $m['id'] ?>" <?= $m['id'] == $rdv['medecin_id'] ? 'selected' : '' ?>>
                    Dr. <?= $m['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Date :</label>
        <input type="date" name="date_rdv" value="<?= $rdv['date_rdv'] ?>" required>

        <label>Heure :</label>
        <input type="time" name="heure_debut" value="<?= $rdv['heure_debut'] ?>" required>

        <label>Statut :</label>
        <select name="statut">
            <option value="Planifié" <?= $rdv['statut'] == 'Planifié' ? 'selected' : '' ?>>Planifié</option>
            <option value="Terminé" <?= $rdv['statut'] == 'Terminé' ? 'selected' : '' ?>>Terminé</option>
            <option value="Annulé" <?= $rdv['statut'] == 'Annulé' ? 'selected' : '' ?>>Annulé</option>
        </select>

        <button type="submit">Mettre à jour le RDV</button>
        <a href="index.php">Annuler</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>