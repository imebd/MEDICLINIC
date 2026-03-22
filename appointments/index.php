<?php
require_once '../config/database.php';
include '../includes/header.php';

$sql = "SELECT r.*, p.nom AS p_nom, p.prenom AS p_prenom, u.nom AS m_nom 
        FROM rendez_vous r
        JOIN patients p ON r.patient_id = p.id
        JOIN utilisateurs u ON r.medecin_id = u.id
        ORDER BY r.date_rdv ASC";
$rdvs = $pdo->query($sql)->fetchAll();
?>
<div class="container">
    <h1>Planning des Rendez-vous</h1>
    <a href="create.php" class="btn-primary">Nouveau RDV</a>
    <table>
        <tr>
            <th>Date & Heure</th>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php foreach($rdvs as $r): ?>
        <tr>
            <td><?= $r['date_rdv'] ?> à <?= $r['heure_debut'] ?></td>
            <td><?= htmlspecialchars($r['p_nom'].' '.$r['p_prenom']) ?></td>
            <td>Dr. <?= htmlspecialchars($r['m_nom']) ?></td>
            <td><span class="badge"><?= $r['statut'] ?></span></td>
            <td>
                <a href="edit.php?id=<?= $r['id'] ?>">Modifier</a>
                <a href="cancel.php?id=<?= $r['id'] ?>" onclick="return confirm('Annuler ?')">Annuler</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>