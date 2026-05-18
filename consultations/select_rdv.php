<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Sécurité : Admin et Secretaire uniquement
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'secretaire') { 
    header('Location: index.php'); 
    exit; 
}

try {
    // Requête simplifiée pour TOUT afficher (pour tester)
    $sql = "SELECT r.id, r.date_rdv, r.heure_debut, r.statut, p.nom, p.prenom 
            FROM rendez_vous r 
            JOIN patients p ON r.patient_id = p.id 
            ORDER BY r.date_rdv DESC";
            
    $stmt = $pdo->query($sql);
    $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}

require_once '../includes/header.php';
?>

<div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 class="page-title">Choisir un Patient pour Consultation 🩺</h2>
        <a href="index.php" class="btn-view" style="color: var(--sidebar-text);">⬅ Retour</a>
    </div>

    <div class="table-container">
        <?php if (empty($rdvs)): ?>
            <div style="text-align: center; padding: 40px;">
                <p style="font-size: 18px; color: #64748b;">🚫 Aucun rendez-vous trouvé dans la base de données.</p>
                <p style="font-size: 14px; color: #94a3b8;">Vérifiez que vos rendez-vous sont bien liés à un ID patient existant.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>PATIENT</th>
                        <th>DATE & HEURE</th>
                        <th>STATUT ACTUEL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rdvs as $r): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars(strtoupper($r['nom'] . ' ' . $r['prenom'])) ?></strong></td>
                        <td><?= date('d/m/Y', strtotime($r['date_rdv'])) ?> à <?= $r['heure_debut'] ?></td>
                        <td>
                            <span class="badge <?= ($r['statut'] == 'confirmé') ? 'badge-success' : 'badge-warning' ?>">
                                <?= htmlspecialchars(strtoupper($r['statut'])) ?>
                            </span>
                        </td>
                        <td>
                            <a href="create.php?rdv_id=<?= $r['id'] ?>" class="btn-primary" style="padding: 8px 15px; text-decoration: none; font-size: 13px; display: inline-block; width: auto;">
                                SELECTIONNER ➡
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>