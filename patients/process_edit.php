<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $sexe = $_POST['sexe'];
    $allergies = htmlspecialchars($_POST['allergies']);
    $antecedents = htmlspecialchars($_POST['antecedents']);

    $sql = "UPDATE patients 
            SET nom = :nom, 
                prenom = :prenom, 
                telephone = :telephone, 
                sexe = :sexe, 
                allergies = :allergies, 
                antecedents = :antecedents 
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone,
            ':sexe' => $sexe,
            ':allergies' => $allergies,
            ':antecedents' => $antecedents,
            ':id' => $id
        ]);

        header("Location: index.php?updated=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}