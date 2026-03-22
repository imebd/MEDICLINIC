<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date_naissance = $_POST['date_naissance'];
    $sexe = $_POST['sexe'];
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $allergies = htmlspecialchars($_POST['allergies']);
    $antecedents = htmlspecialchars($_POST['antecedents']);

    $sql = "INSERT INTO patients (nom, prenom, date_naissance, sexe, telephone, email, adresse, allergies, antecedents) 
            VALUES (:nom, :prenom, :date_naissance, :sexe, :telephone, :email, :adresse, :allergies, :antecedents)";

    try {
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
            ':antecedents' => $antecedents
        ]);

        
        header("Location: index.php?success=1");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de l'ajout : " . $e->getMessage());
    }
} else {
    header("Location: add_patient.php");
    exit();
}