<?php
require_once '../includes/auth.php';

// Sécurité : Seul l'admin gère la facturation [cite: 2026-03-21]
if ($_SESSION['role'] !== 'admin') { 
    header('Location: ../dashboard/index.php'); 
    exit; 
}

require_once '../config/database.php';

$sql = "SELECT f.*, p.nom, p.prenom FROM factures f 
        JOIN consultations c ON f.consultation_id = c.id 
        JOIN patients p ON c.patient_id = p.id 
        ORDER BY f.id DESC";
$factures = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 class="page-title" style="margin: 0;">Gestion Factures 💳</h2>
    <a href="create.php" class="btn-edit" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
        + Nouvelle Facture
    </a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($factures as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['nom'].' '.$f['prenom']) ?></td>
                <td><strong><?= $f['montant'] ?> MAD</strong></td>
                <td>
                    <span class="badge <?= $f['statut_paiement']=='payée'?'badge-success':'badge-danger' ?>">
                        <?= $f['statut_paiement'] ?>
                    </span>
                </td>
                <td class="actions">
                    <?php if($f['statut_paiement'] !== 'payée'): ?>
                        <a href="update_status.php?id=<?= $f['id'] ?>&statut=payée" class="btn-view" style="background-color: #007bff;">Marquer Payée</a>
                    <?php else: ?>
                        <a href="update_status.php?id=<?= $f['id'] ?>&statut=non_payée" class="btn-edit">Annuler Paiement</a>
                    <?php endif; ?>
                    <a href="delete.php?id=<?= $f['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer cette facture ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>