<?php
require_once '../includes/auth.php'; // Vérification de la session
require_once '../config/database.php';

$id_user = $_SESSION['user_id'];
$role = $_SESSION['role'];

// LOGIQUE D'ACCÈS : Seuls Admin, Secrétaire et Médecin voient cette liste
try {
    if ($role === 'medecin') {
        // Le médecin ne voit que les patients avec qui il a un rendez-vous
        $sql = "SELECT DISTINCT p.* FROM patients p 
                JOIN rendez_vous r ON p.id = r.patient_id 
                WHERE r.medecin_id = :id 
                ORDER BY p.nom ASC";
        $stmt = $pdo->prepare($sql); 
        $stmt->execute(['id' => $id_user]);
    } else {
        // L'Admin et la Secrétaire voient tous les patients
        $stmt = $pdo->query("SELECT * FROM patients ORDER BY nom ASC");
    }
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des patients.");
}

// Inclusion du header qui contient la Sidebar et ouvre la div .main-content
require_once '../includes/header.php';
?>

<div class="patients-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h2 class="page-title" style="margin: 0;">Gestion des Patients 👥</h2>
    
    <?php if ($role === 'admin' || $role === 'secretaire'): ?>
        <a href="create.php" class="btn-primary" style="width: auto; padding: 10px 20px; text-decoration: none;">
            <i class="fas fa-user-plus"></i> Ajouter un patient
        </a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>NOM & PRÉNOM</th>
                <th>TÉLÉPHONE</th>
                <th>ADRESSE</th>
                <th style="text-align: center;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($patients)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">
                        Aucun patient trouvé dans la base de données.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($patients as $p): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($p['telephone'] ?? 'Non renseigné') ?></td>
                        <td><?= htmlspecialchars($p['adresse'] ?? '-') ?></td>
                        <td class="actions" style="text-align: center; display: flex; justify-content: center; gap: 10px;">
                            <a href="show.php?id=<?= $p['id'] ?>" class="btn-view" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <?php if ($role === 'admin' || $role === 'secretaire'): ?>
                                <a href="edit.php?id=<?= $p['id'] ?>" class="btn-edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($role === 'admin'): ?>
                                <a href="delete.php?id=<?= $p['id'] ?>" class="btn-delete" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?');" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
// Ferme les balises ouvertes dans le header
require_once '../includes/footer.php'; 
?>