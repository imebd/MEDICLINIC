<?php
require_once '../config/database.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql = "INSERT INTO rendez_vous (patient_id, medecin_id, date_rdv, heure_debut, motif, statut) 
            VALUES (?, ?, ?, ?, ?, 'Planifié')";
    $pdo->prepare($sql)->execute([
        $_POST['patient_id'], $_POST['medecin_id'], 
        $_POST['date_rdv'], $_POST['heure_debut'], $_POST['motif']
    ]);
    header("Location: index.php");
}