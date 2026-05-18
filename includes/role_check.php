<?php

function verifierRole($rolesAutorises)
{
    if (!isset($_SESSION['utilisateur'])) {
        header("Location: /mediclinic_app/auth/login.php");
        exit;
    }

    $roleUtilisateur = $_SESSION['utilisateur']['role'];

    if (!in_array($roleUtilisateur, $rolesAutorises)) {
        die("Accès refusé.");
    }
}