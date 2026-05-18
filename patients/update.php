<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$id = $_POST['id'] ?? null;
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$date_naissance = !empty($_POST['date_naissance']) ? $_POST['date_naissance'] : null;
$sexe = !empty($_POST['sexe']) ? $_POST['sexe'] : null;
$telephone = trim($_POST['telephone'] ?? '');
$email = trim($_POST['email'] ?? '');
$adresse = trim($_POST['adresse'] ?? '');
$allergies = trim($_POST['allergies'] ?? '');
$antecedents = trim($_POST['antecedents'] ?? '');

if (!$id || $nom === '' || $prenom === '') {
    die("Informations invalides.");
}

$sql = "UPDATE patients SET
            nom = :nom,
            prenom = :prenom,
            date_naissance = :date_naissance,
            sexe = :sexe,
            telephone = :telephone,
            email = :email,
            adresse = :adresse,
            allergies = :allergies,
            antecedents = :antecedents
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':date_naissance' => $date_naissance,
    ':sexe' => $sexe,
    ':telephone' => $telephone,
    ':email' => $email,
    ':adresse' => $adresse,
    ':allergies' => $allergies,
    ':antecedents' => $antecedents,
    ':id' => $id
]);

header('Location: index.php');
exit;
?>