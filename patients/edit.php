<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->execute([$id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    die("Patient introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Patient - MEDICLINIC</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Modifier le dossier : <?= htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']) ?></h2>
        
        <form action="process_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $patient['id'] ?>">

            <div class="form-group">
                <label>Nom :</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($patient['nom']) ?>" required>
            </div>

            <div class="form-group">
                <label>Prénom :</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($patient['prenom']) ?>" required>
            </div>

            <div class="form-group">
                <label>Téléphone :</label>
                <input type="tel" name="telephone" value="<?= htmlspecialchars($patient['telephone']) ?>">
            </div>

            <div class="form-group">
                <label>Sexe :</label>
                <select name="sexe">
                    <option value="Homme" <?= $patient['sexe'] == 'Homme' ? 'selected' : '' ?>>Homme</option>
                    <option value="Femme" <?= $patient['sexe'] == 'Femme' ? 'selected' : '' ?>>Femme</option>
                </select>
            </div>

            <div class="form-group">
                <label>Allergies :</label>
                <textarea name="allergies"><?= htmlspecialchars($patient['allergies']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Antécédents :</label>
                <textarea name="antecedents"><?= htmlspecialchars($patient['antecedents']) ?></textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn-save">Enregistrer les modifications</button>
                <a href="index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>