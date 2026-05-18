<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id_user = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Récupération des consultations
$sql = "SELECT c.*, p.nom, p.prenom, r.date_rdv 
        FROM consultations c 
        JOIN rendez_vous r ON c.rendez_vous_id = r.id 
        JOIN patients p ON r.patient_id = p.id";

if ($role === 'medecin') {
    $sql .= " WHERE r.medecin_id = :id ORDER BY c.id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id_user]);
} else {
    $sql .= " ORDER BY c.id DESC";
    $stmt = $pdo->query($sql);
}
$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 class="page-title" style="margin: 0;">Historique des Consultations 🩺</h2>
    
    <?php if ($role === 'admin'): ?>
        <a href="select_rdv.php" class="btn-edit" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: flex; align-items: center;">
            <span style="font-size: 20px; margin-right: 8px;">+</span> Nouvelle Consultation
        </a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>DATE RDV</th>
                <th>PATIENT</th>
                <th>DIAGNOSTIC</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultations as $cons): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($cons['date_rdv'])) ?></td>
                <td><?= htmlspecialchars($cons['nom'] . " " . $cons['prenom']) ?></td>
                <td><?= htmlspecialchars(substr($cons['diagnostic'], 0, 50)) ?>...</td>
                <td class="actions">
                    <a href="show.php?id=<?= $cons['id'] ?>" class="btn-view" style="color: #28a745;">Voir</a>
                    <?php if ($role === 'admin'): ?>
                        <a href="delete.php?id=<?= $cons['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer ?');">Supprimer</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>