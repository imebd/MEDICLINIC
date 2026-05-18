<?php
require_once '../includes/auth.php'; 
require_once '../config/database.php';

$id_user = $_SESSION['user_id'];
$role = $_SESSION['role'];

// --- LOGIQUE DE RÉCUPÉRATION SELON LE RÔLE ---
try {
    if ($role === 'admin' || $role === 'secretaire') {
        // L'administration voit tout pour valider les demandes [cite: 2026-03-21]
        $sql = "SELECT r.*, p.nom as p_nom, p.prenom as p_prenom, u.nom as m_nom 
                FROM rendez_vous r 
                JOIN patients p ON r.patient_id = p.id 
                JOIN utilisateurs u ON r.medecin_id = u.id 
                ORDER BY FIELD(r.statut, 'en_attente', 'confirmé', 'annulé'), r.date_rdv DESC";
        $stmt = $pdo->query($sql);
    } elseif ($role === 'medecin') {
        // Le médecin voit UNIQUEMENT les rendez-vous CONFIRMÉS [cite: 2026-03-12]
        $sql = "SELECT r.*, p.nom as p_nom, p.prenom as p_prenom 
                FROM rendez_vous r 
                JOIN patients p ON r.patient_id = p.id 
                WHERE r.medecin_id = :id AND r.statut = 'confirmé' 
                ORDER BY r.date_rdv ASC, r.heure_debut ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id_user]);
    } else {
        // Le patient voit son historique personnel [cite: 2026-03-31]
        $sql = "SELECT r.*, u.nom as m_nom 
                FROM rendez_vous r 
                JOIN utilisateurs u ON r.medecin_id = u.id 
                JOIN patients p ON r.patient_id = p.id
                WHERE p.utilisateur_id = :id 
                ORDER BY r.date_rdv DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id_user]);
    }
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de base de données.");
}

require_once '../includes/header.php'; // Inclut Topbar + Sidebar [cite: 2026-03-21]
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h2 class="page-title" style="margin: 0;">Gestion des Rendez-vous 📅</h2>
    <?php if ($role === 'admin' || $role === 'patient'): ?>
        <a href="create.php" class="btn-primary" style="width: auto; padding: 10px 20px; text-decoration: none;">
            + <?= ($role === 'admin') ? 'Nouveau RDV' : 'Demander un RDV' ?>
        </a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>DATE & HEURE</th>
                <?php if($role !== 'patient'): ?><th>PATIENT</th><?php endif; ?>
                <?php if($role !== 'medecin'): ?><th>MÉDECIN</th><?php endif; ?>
                <th>STATUT</th>
                <th style="text-align: center;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($appointments)): ?>
                <tr><td colspan="5" style="text-align:center; padding:30px; color:#94a3b8;">Aucun rendez-vous trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td>
                            <strong><?= date('d/m/Y', strtotime($a['date_rdv'])) ?></strong><br>
                            <small><?= htmlspecialchars($a['heure_debut']) ?></small>
                        </td>
                        
                        <?php if($role !== 'patient'): ?>
                            <td><?= htmlspecialchars($a['p_nom'] . ' ' . $a['p_prenom']) ?></td>
                        <?php endif; ?>
                        
                        <?php if($role !== 'medecin'): ?>
                            <td>Dr. <?= htmlspecialchars($a['m_nom'] ?? 'À définir') ?></td>
                        <?php endif; ?>
                        
                        <td>
                            <?php 
                            $s = strtolower($a['statut']);
                            $badge = ($s == 'confirmé' || $s == 'confirme') ? 'badge-success' : (($s == 'annulé' || $s == 'annule') ? 'badge-danger' : 'badge-warning');
                            ?>
                            <span class="badge <?= $badge ?>"><?= strtoupper($a['statut']) ?></span>
                        </td>

                        <td style="text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                
                                <?php if (($role === 'admin' || $role === 'secretaire') && $s === 'en_attente'): ?>
                                    <a href="validate.php?id=<?= $a['id'] ?>&action=confirmé" 
                                       style="background-color: #10b981; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 11px; font-weight: bold;">
                                       CONFIRMER
                                    </a>
                                    <a href="validate.php?id=<?= $a['id'] ?>&action=annulé" 
                                       style="background-color: #ef4444; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 11px; font-weight: bold;"
                                       onclick="return confirm('Refuser ce rendez-vous ?');">
                                       ANNULER
                                    </a>
                                <?php endif; ?>

                                <a href="show.php?id=<?= $a['id'] ?>" class="btn-view" style="font-size: 11px; font-weight: bold;">VOIR</a>
                                
                                <?php if ($role === 'admin'): ?>
                                    <a href="edit.php?id=<?= $a['id'] ?>" class="btn-edit" style="font-size: 11px; font-weight: bold;">MODIFIER</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>