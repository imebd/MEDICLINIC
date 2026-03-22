<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $patient_id = $_POST['patient_id'];
    $medecin_id = $_POST['medecin_id'];
    $date_rdv = $_POST['date_rdv'];
    $heure = $_POST['heure_debut'];
    $statut = $_POST['statut'];

    $sql = "UPDATE rendez_vous 
            SET patient_id = ?, medecin_id = ?, date_rdv = ?, heure_debut = ?, statut = ? 
            WHERE id = ?";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$patient_id, $medecin_id, $date_rdv, $heure, $statut, $id]);
        
        header("Location: index.php?updated=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur SQL : " . $e->getMessage());
    }
}