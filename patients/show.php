<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID manquant.");
}

// --- LOGIQUE DE RECHERCHE DU PATIENT ---
// On cherche d'abord par l'ID de la table 'patients'
$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = :id");
$stmt->execute([':id' => $id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

// Si non trouvé (cas du clic depuis la sidebar avec user_id), on cherche via utilisateur_id
if (!$patient) {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE utilisateur_id = :id");
    $stmt->execute([':id' => $id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$patient) {
    die("<div style='padding:20px; color:red;'>Erreur : Dossier patient introuvable pour l'ID " . htmlspecialchars($id) . "</div>");
}

$real_patient_id = $patient['id'];

// Récupération des rendez-vous
$stmtRdv = $pdo->prepare("SELECT r.*, u.nom as medecin_nom 
                          FROM rendez_vous r 
                          JOIN utilisateurs u ON r.medecin_id = u.id 
                          WHERE r.patient_id = :id 
                          ORDER BY r.date_rdv DESC");
$stmtRdv->execute([':id' => $real_patient_id]);
$rendezVous = $stmtRdv->fetchAll(PDO::FETCH_ASSOC);

// Récupération des consultations
$stmtConsult = $pdo->prepare("SELECT * FROM consultations WHERE patient_id = :id ORDER BY date_consultation DESC");
$stmtConsult->execute([':id' => $real_patient_id]);
$consultations = $stmtConsult->fetchAll(PDO::FETCH_ASSOC);

// --- AFFICHAGE ---
require_once '../includes/header.php'; // Topbar + Ouverture Layout
require_once '../includes/sidebar.php'; // Sidebar à gauche
?>

<div class="main-content" style="flex: 1; padding: 30px;">
    <h2 class="page-title" style="margin-bottom: 20px;">Dossier Médical : <?= htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']) ?></h2>

    <div class="table-container" style="margin-bottom: 30px; padding: 20px;">
        <h3 style="color: var(--primary); margin-bottom: 15px;"><i class="fas fa-user-circle"></i> Informations Générales</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <p><strong>Téléphone :</strong> <?= htmlspecialchars($patient['telephone'] ?? 'Non spécifié') ?></p>
            <p><strong>Sexe :</strong> <?= htmlspecialchars($patient['sexe'] ?? '-') ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($patient['email'] ?? '-') ?></p>
            <p><strong>Ville :</strong> <?= htmlspecialchars($patient['ville'] ?? '-') ?></p>
        </div>
    </div>

    <div class="table-container" style="margin-bottom: 30px;">
        <h3 style="margin-bottom: 15px;"><i class="fas fa-calendar-alt"></i> Historique des Rendez-vous</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Médecin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rendezVous): ?>
                    <?php foreach ($rendezVous as $rdv): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($rdv['date_rdv'])) ?></td>
                            <td><?= htmlspecialchars($rdv['heure_debut']) ?></td>
                            <td>Dr. <?= htmlspecialchars($rdv['medecin_nom']) ?></td>
                            <td>
                                <?php 
                                $s = strtolower($rdv['statut']);
                                $class = ($s == 'confirmé' || $s == 'confirme') ? 'badge-success' : (($s == 'annulé' || $s == 'annule') ? 'badge-danger' : 'badge-warning');
                                ?>
                                <span class="badge <?= $class ?>"><?= strtoupper($rdv['statut']) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;">Aucun rendez-vous trouvé.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <h3 style="margin-bottom: 15px;"><i class="fas fa-stethoscope"></i> Consultations passées</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Diagnostic</th>
                    <th>Traitement</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($consultations): ?>
                    <?php foreach ($consultations as $c): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($c['date_consultation'])) ?></td>
                            <td><?= htmlspecialchars(substr($c['diagnostic'], 0, 50)) ?>...</td>
                            <td><?= htmlspecialchars(substr($c['traitement'], 0, 50)) ?>...</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align:center;">Aucune consultation enregistrée.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>