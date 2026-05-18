<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/auth.php';
require_once '../config/database.php';

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$date_naissance = !empty($_POST['date_naissance']) ? $_POST['date_naissance'] : null;
$sexe = !empty($_POST['sexe']) ? $_POST['sexe'] : null;
$telephone = trim($_POST['telephone'] ?? '');
$email = trim($_POST['email'] ?? '');
$adresse = trim($_POST['adresse'] ?? '');
$allergies = trim($_POST['allergies'] ?? '');
$antecedents = trim($_POST['antecedents'] ?? '');

if ($nom === '' || $prenom === '') {
    die("Le nom et le prénom sont obligatoires.");
}

$sql = "INSERT INTO patients (
            nom,
            prenom,
            date_naissance,
            sexe,
            telephone,
            email,
            adresse,
            allergies,
            antecedents
        ) VALUES (
            :nom,
            :prenom,
            :date_naissance,
            :sexe,
            :telephone,
            :email,
            :adresse,
            :allergies,
            :antecedents
        )";

$stmt = $pdo->prepare($sql);

$ok = $stmt->execute([
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':date_naissance' => $date_naissance,
    ':sexe' => $sexe,
    ':telephone' => $telephone,
    ':email' => $email,
    ':adresse' => $adresse,
    ':allergies' => $allergies,
    ':antecedents' => $antecedents
]);

if ($ok) {
    header('Location: index.php');
    exit;
} else {
    die("Erreur lors de l'enregistrement du patient.");
}
?>