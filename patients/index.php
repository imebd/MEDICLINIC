<?php
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM patients ORDER BY nom ASC");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de récupération : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MediClinic - Liste des Patients</title>
    <link rel="stylesheet" href="../assets/css/style.css"> </head>
<body>
    <div class="container">
        <h1>Gestion des Patients</h1>
        
        <div class="actions">
            <a href="add_patient.php" class="btn-add">Add New Patient</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($patients) > 0): ?>
                    <?php foreach ($patients as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['nom']) ?></td>
                            <td><?= htmlspecialchars($p['prenom']) ?></td>
                            <td><?= htmlspecialchars($p['sexe']) ?></td>
                            <td><?= htmlspecialchars($p['telephone']) ?></td>
                            <td><?= htmlspecialchars($p['email']) ?></td>
                            <td>
                                <a href="view.php?id=<?= $p['id'] ?>">Voir</a> |
                                <a href="edit.php?id=<?= $p['id'] ?>">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun patient trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>