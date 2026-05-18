<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - MediClinic</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-page">

    <div class="login-box">
        <div class="login-logo">
            <h1>MediClinic</h1>
            <p>Application de gestion de clinique</p>
        </div>

        <?php if(isset($_GET['registration']) && $_GET['registration'] === 'success'): ?>
            <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 10px; text-align: center; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                Compte créé ! Connectez-vous.
            </div>
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="exemple@mail.com" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-primary">Se connecter</button>
        </form>

        <div class="register-section">
            <p style="color: #64748b; font-size: 13px; margin-bottom: 10px;">Vous n'avez pas encore de compte ?</p>
            <a href="register.php" class="btn-outline-primary">
                Créer mon compte patient 
            </a>
        </div>
    </div>

</body>
</html>