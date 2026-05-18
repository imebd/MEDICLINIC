<?php
require_once '../includes/auth.php';

if ($_SESSION['role'] !== 'admin') { 
    header('Location: index.php'); 
    exit; 
}

require_once '../config/database.php';

$sql = "SELECT c.id, c.diagnostic, p.nom, p.prenom
        FROM consultations c
        JOIN patients p ON c.patient_id = p.id
        WHERE c.id NOT IN (SELECT consultation_id FROM factures)
        ORDER BY c.id DESC";

$stmt = $pdo->query($sql);
$consultationsDisponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<h2 class="page-title">Émettre une facture</h2>

<div class="form-card">
    <form action="store.php" method="POST">
        <div class="form-group">
            <label>Choisir la Consultation</label>
            <select name="consultation_id" class="form-control" required>
                <option value="">-- Sélectionner --</option>
                <?php foreach ($consultationsDisponibles as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        ID #<?= $c['id'] ?> - <?= htmlspecialchars($c['nom'].' '.$c['prenom']) ?> (<?= htmlspecialchars($c['diagnostic']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Montant (MAD)</label>
            <input type="number" step="0.01" name="montant" class="form-control" placeholder="0.00" required>
        </div>

        <div class="form-group">
            <label>État initial</label>
            <select name="statut_paiement" class="form-control">
                <option value="non_payée">Non payée</option>
                <option value="payée">Payée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Générer la facture</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>