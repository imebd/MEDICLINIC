<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
?>

<h2 class="page-title">Ajouter un patient</h2>

<div class="form-card">
    <form action="store.php" method="POST">

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date_naissance">Date de naissance</label>
            <input type="date" id="date_naissance" name="date_naissance" class="form-control">
        </div>

        <div class="form-group">
            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" class="form-control">
                <option value="">Choisir</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="adresse">Adresse</label>
            <textarea id="adresse" name="adresse" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="allergies">Allergies</label>
            <textarea id="allergies" name="allergies" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="antecedents">Antécédents médicaux</label>
            <textarea id="antecedents" name="antecedents" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
