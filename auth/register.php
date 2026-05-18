<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tel = $_POST['telephone'];

    try {
        $pdo->beginTransaction();
        // Création utilisateur
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, 'patient')");
        $stmt->execute([$nom, $prenom, $email, $password]);
        $user_id = $pdo->lastInsertId();

        // Création profil patient lié
        $stmt2 = $pdo->prepare("INSERT INTO patients (utilisateur_id, nom, prenom, telephone) VALUES (?, ?, ?, ?)");
        $stmt2->execute([$user_id, $nom, $prenom, $tel]);

        $pdo->commit();
        header('Location: login.php?registration=success');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erreur : " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rejoindre MediClinic</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <h1>Rejoindre <span>MediClinic</span> 🩺</h1>
        </div>
        <form method="POST">
            <div style="display: flex; gap: 10px;">
                <div class="form-group"><label>Nom</label><input type="text" name="nom" class="form-control" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" name="prenom" class="form-control" required></div>
            </div>
            <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="form-group"><label>Mot de passe</label><input type="password" name="password" class="form-control" required></div>
            <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" class="form-control" required></div>
            <button type="submit" class="btn-primary">CRÉER MON COMPTE 🚀</button>
        </form>
        <p style="text-align:center; margin-top:15px; font-size:13px;">Déjà inscrit ? <a href="login.php" style="color:var(--primary); font-weight:bold;">Se connecter ici</a></p>
    </div>
</body>
</html>