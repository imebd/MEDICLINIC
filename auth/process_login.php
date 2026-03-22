<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $db_password = trim($user['mot_de_passe']);

        
        if ($password === $db_password || password_verify($password, $db_password)) {
            // On donne le badge de session à l'utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            
            // REDIRECTION VERS LE DASHBOARD
            header('Location: ../dashboard/index.php');
            exit();
        }
    }
    
    // Si échec, retour au login avec erreur
    header('Location: login.php?error=1');
    exit();
}