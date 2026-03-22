<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->execute([$id]);
$patient = $stmt->fetch();

if (!$patient) {
    die("Patient introuvable.");
}?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dossier de <?= htmlspecialchars($patient['nom']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <a href="index.php">⬅ Retour à la liste</a>
        <h1>Dossier Médical : <?= htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']) ?></h1>

        <div class="patient-card">
            <p><strong>Sexe :</strong> <?= $patient['sexe'] ?></p>
            <p><strong>Date de naissance :</strong> <?= $patient['date_naissance'] ?></p>
            <p><strong>Téléphone :</strong> <?= $patient['telephone'] ?></p>
            <p><strong>Email :</strong> <?= $patient['email'] ?></p>
            <hr>
            <h3>Informations Médicales</h3>
            <p><strong>Allergies :</strong> <?= nl2br(htmlspecialchars($patient['allergies'])) ?></p>
            <p><strong>Antécédents :</strong> <?= nl2br(htmlspecialchars($patient['antecedents'])) ?></p>
        </div>
        
        <div class="actions">
            <a href="edit.php?id=<?= $patient['id'] ?>" class="btn-edit">Modifier le dossier</a>
        </div>
    </div>
</body>
</html>