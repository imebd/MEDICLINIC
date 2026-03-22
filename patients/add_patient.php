<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Patient - MediClinic</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Enregistrer un nouveau patient</h2>
        <form action="process_add.php" method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            
            <label>Date de naissance :</label>
            <input type="date" name="date_naissance">
            
            <select name="sexe">
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
            
            <input type="tel" name="telephone" placeholder="Téléphone">
            <input type="email" name="email" placeholder="Email">
            
            <textarea name="adresse" placeholder="Adresse"></textarea>
            <textarea name="allergies" placeholder="Allergies (si aucune, laisser vide)"></textarea>
            <textarea name="antecedents" placeholder="Antécédents médicaux"></textarea>
            
            <button type="submit" class="btn-save">Enregistrer le patient</button>
            <a href="index.php">Annuler</a>
        </form>
    </div>
</body>
</html>