<?php
require_once '../includes/auth.php'; //
require_once '../config/database.php';

$id_user = $_SESSION['user_id'];
$role = $_SESSION['role'];

try {
    if ($role === 'patient') {
        $sql = "SELECT r.*, u.nom as medecin_nom 
                FROM rendez_vous r 
                JOIN patients p ON r.patient_id = p.id 
                JOIN utilisateurs u ON r.medecin_id = u.id 
                WHERE p.utilisateur_id = :uid 
                ORDER BY r.date_rdv DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['uid' => $id_user]);
        $my_appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Logique pour Admin/Médecin (inchangée)
        $p = $pdo->prepare("SELECT COUNT(*) FROM patients");
        $p->execute(); $res_p = $p->fetchColumn();
        $r = $pdo->prepare("SELECT COUNT(*) FROM rendez_vous");
        $r->execute(); $res_r = $r->fetchColumn();
    }
} catch (PDOException $e) { die("Erreur base de données"); }

require_once '../includes/header.php'; 
// On inclut la sidebar.php ici pour qu'elle soit à gauche du contenu
require_once '../includes/sidebar.php'; //
?>

<div class="main-content" style="flex: 1; padding: 30px;">
    
    <h2 style="margin-bottom: 25px;">Tableau de bord ✨</h2>

    <?php if ($role === 'patient'): ?>
        <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; border: 2px dashed var(--primary); margin-bottom: 30px;">
            <h3 style="color: var(--primary);">Besoin d'un médecin ?</h3>
            <p style="color: #64748b; margin-bottom: 20px;">Prenez rendez-vous en quelques secondes.</p>
            <a href="../appointments/create_patient.php" class="btn-primary" style="display: inline-block; width: auto; padding: 12px 30px; text-decoration: none;">
                <i class="fas fa-calendar-plus"></i> PRENDRE UN RENDEZ-VOUS
            </a>
        </div>

        <div class="table-container">
            <h3 style="margin-bottom: 20px;"><i class="fas fa-bell"></i> Mes Rendez-vous</h3>
            <?php if (empty($my_appointments)): ?>
                <p style="text-align:center; color:#94a3b8;">Aucun rendez-vous pour le moment.</p>
            <?php else: ?>
                <?php foreach ($my_appointments as $rdv): ?>
                    <?php 
                        $s = strtolower($rdv['statut']);
                        $border = ($s == 'confirmé' || $s == 'confirme') ? '#10b981' : (($s == 'annulé' || $s == 'annule') ? '#ef4444' : '#f59e0b');
                    ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: white; margin-bottom: 10px; border-radius: 12px; border-left: 6px solid <?= $border ?>; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <div>
                            <strong>Dr. <?= htmlspecialchars($rdv['medecin_nom']) ?></strong><br>
                            <small><?= date('d/m/Y', strtotime($rdv['date_rdv'])) ?> à <?= $rdv['heure_debut'] ?></small>
                        </div>
                        <span style="font-weight: bold; color: <?= $border ?>;">
                            <?= ($s == 'confirmé' || $s == 'confirme') ? 'CONFIRMÉ' : (($s == 'annulé' || $s == 'annule') ? 'REFUSÉ' : 'EN ATTENTE') ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="dashboard" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div class="card"><h3>Patients</h3><p><?= $res_p ?></p></div>
            <div class="card"><h3>Rendez-vous</h3><p><?= $res_r ?></p></div>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>