<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$nom_docteur = $_SESSION['user_nom'];

$countPatients = $pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn() ?: 0;
$countRDV = $pdo->query("SELECT COUNT(*) FROM rendez_vous")->fetchColumn() ?: 0;
$countConsultations = $pdo->query("SELECT COUNT(*) FROM consultations")->fetchColumn() ?: 0;
$countFactures = $pdo->query("SELECT COUNT(*) FROM factures")->fetchColumn() ?: 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MEDICLINIC</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header class="top-navbar">
        <div class="logo">MEDICLINIC</div>
        <div class="nav-right">
            <span class="date-text">📅 <?php echo date('d M Y'); ?></span>
            <span>Connecté : Dr. <?php echo htmlspecialchars($nom_docteur); ?></span>
            <a href="../auth/logout.php" class="logout-link">Deconnexion</a>
        </div>
    </header>

    <div class="main-container">
        <nav class="sidebar">
            <h2>MENU</h2>
            <ul>
                <li><a href="index.php" class="active">Tableau de bord</a></li>
                <li><a href="patients.php">Patients</a></li>
                <li><a href="rendezvous.php">Rendez-vous</a></li>
                <li><a href="consultations.php">Consultations</a></li>
                <li><a href="factures.php">Factures</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="welcome-section">
                <h1>Bienvenue, Dr. <?php echo htmlspecialchars($nom_docteur); ?></h1>
                <p>Voici le résumé de l'activité de la clinique.</p>
            </div>

            <section class="stats-grid">
                <div class="stat-card"><h3>Patients</h3><span class="value"><?php echo $countPatients; ?></span></div>
                <div class="stat-card"><h3>Rendez-vous</h3><span class="value"><?php echo $countRDV; ?></span></div>
                <div class="stat-card"><h3>Consultations</h3><span class="value"><?php echo $countConsultations; ?></span></div>
                <div class="stat-card"><h3>Factures</h3><span class="value"><?php echo $countFactures; ?></span></div>
            </section>

            <div class="appointments-section">
                <h2>Derniers Rendez-vous</h2>
                <p>Aucun rendez-vous pour le moment.</p>
            </div>
        </main>
    </div>

</body>
</html>