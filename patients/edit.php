<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Patient introuvable.");
}

$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = :id");
$stmt->execute([':id' => $id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    die("Patient introuvable.");
}

require_once '../includes/header.php';
?>

<h2 class="page-title">Modifier un patient</h2>

<div class="form-card">
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $patient['id'] ?>">

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($patient['nom']) ?>" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" value="<?= htmlspecialchars($patient['prenom']) ?>" required>
        </div>

        <div class="form-group">
            <label for="date_naissance">Date de naissance</label>
            <input type="date" id="date_naissance" name="date_naissance" class="form-control" value="<?= htmlspecialchars($patient['date_naissance']) ?>">
        </div>

        <div class="form-group">
            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" class="form-control">
                <option value="">Choisir</option>
                <option value="Homme" <?= $patient['sexe'] === 'Homme' ? 'selected' : '' ?>>Homme</option>
                <option value="Femme" <?= $patient['sexe'] === 'Femme' ? 'selected' : '' ?>>Femme</option>
            </select>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="form-control" value="<?= htmlspecialchars($patient['telephone']) ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($patient['email']) ?>">
        </div>

        <div class="form-group">
            <label for="adresse">Adresse</label>
            <textarea id="adresse" name="adresse" class="form-control"><?= htmlspecialchars($patient['adresse']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="allergies">Allergies</label>
            <textarea id="allergies" name="allergies" class="form-control"><?= htmlspecialchars($patient['allergies']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="antecedents">Antécédents médicaux</label>
            <textarea id="antecedents" name="antecedents" class="form-control"><?= htmlspecialchars($patient['antecedents']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>