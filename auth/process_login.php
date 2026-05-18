<?php
session_start();
require_once '../config/database.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM utilisateurs WHERE email = :email AND actif = 1 LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $password === $user['mot_de_passe']) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['prenom'] = $user['prenom']; // <-- RECTIFICATION ICI
    $_SESSION['role'] = $user['role'];

    header('Location: ../dashboard/index.php');
    exit;
} else {
    die("Email ou mot de passe incorrect.");
}