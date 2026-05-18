<?php
require_once '../includes/auth.php';
if ($_SESSION['role'] !== 'admin') { header('Location: index.php'); exit(); }
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM rendez_vous WHERE id = ?");
$stmt->execute([$id]);
$rdv = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$rdv) { die("RDV introuvable"); }

$patients = $pdo->query("SELECT id, nom, prenom FROM patients ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
$medecins = $pdo->query("SELECT id, nom, prenom FROM utilisateurs WHERE role = 'medecin' AND actif = 1 ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>
<h2 class="page-title">Modifier le rendez-vous</h2>
<div class="form-card">
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $rdv['id'] ?>">
        <div class="form-group">
            <label>Patient</label>
            <select name="patient_id" class="form-control">
                <?php foreach ($patients as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= $rdv['patient_id']==$p['id']?'selected':'' ?>><?= htmlspecialchars($p['nom'].' '.$p['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date_rdv" class="form-control" value="<?= $rdv['date_rdv'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>