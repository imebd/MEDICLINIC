<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MediClinic 🏥</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=8.0">
    <style>
        /* Correction rapide pour l'alignement si ton CSS n'est pas à jour */
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #fff; border-right: 1px solid #e2e8f0; flex-shrink: 0; }
        .main-content { flex-grow: 1; padding: 30px; background: #f8fafc; overflow-x: hidden; }
        .topbar { background: #fff; border-bottom: 3px solid #10b981; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>

<div class="topbar">
    <h1 style="color: #10b981; font-size: 24px; font-weight: 800;">MediClinic 🏥</h1>
    <div class="user-info">
        Connecté : <strong><?= htmlspecialchars(($_SESSION['prenom'] ?? '') . ' ' . ($_SESSION['nom'] ?? '')) ?></strong> | 
        <a href="../auth/logout.php" style="color: #ef4444; text-decoration: none; font-weight: bold;">Déconnexion</a>
    </div>
</div>

<div class="layout">
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">