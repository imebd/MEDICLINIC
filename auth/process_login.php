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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            die("SUCCÈS : La connexion fonctionne enfin !");
        } else {
            die("ÉCHEC : Le mot de passe ne correspond pas. Tu as tapé '" . $password . "' et la base contient '" . $db_password . "'");
        }
    } else {
        die("ÉCHEC : Email inconnu dans la base.");
    }
}