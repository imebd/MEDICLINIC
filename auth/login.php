<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connecion-MEDICLINIC</Title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-header">
        <h1>MEDICLINIC</h1>
        <p>Gestion de Clinique Medical</p>
    </div>

    <form action="process_login.php" method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required placeholder="nom@email.com">
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required placeholder="****">
        </div>
        <button type="submit" class="btn-login">Se connecter</button>

        <?php if(isset($_GET['error'])): ?>
                    <p class="error-msg">Email ou mot de passe incorrect.</p>
                <?php endif; ?>
    </form>
   
</body>
</html>
