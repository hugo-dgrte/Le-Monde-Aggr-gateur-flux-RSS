<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Le Monde</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Le Monde</h1>
        <p>Agrégateur de flux</p>
    </header>
    <main>
        <div class="card">
            <h2>Inscription</h2>
            <p class="subtitle">Créez votre compte pour accéder aux flux RSS</p>
            <form action="assets/functions/validation_inscription.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom complet</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Centres d'intérêt</label>
                    <div class="checkbox-list">
                        <label><input type="checkbox" name="thematiques[]" value="politique"> Politique</label>
                        <label><input type="checkbox" name="thematiques[]" value="economie"> Économie</label>
                        <label><input type="checkbox" name="thematiques[]" value="culture"> Culture</label>
                        <label><input type="checkbox" name="thematiques[]" value="sport"> Sport</label>
                        <label><input type="checkbox" name="thematiques[]" value="sciences"> Sciences</label>
                        <label><input type="checkbox" name="thematiques[]" value="international"> International</label>
                        <label><input type="checkbox" name="thematiques[]" value="education"> Éducation</label>
                        <label><input type="checkbox" name="thematiques[]" value="planete"> Planète</label>
                        <label><input type="checkbox" name="thematiques[]" value="pixels"> Pixels</label>
                        <label><input type="checkbox" name="thematiques[]" value="idees"> Opinions</label>
                    </div>
                </div>
                <button type="submit" class="btn">S'inscrire</button>
            </form>
            <p class="link-text">Déjà inscrit ? <a href="index.php">Se connecter</a></p>
        </div>
    </main>
</body>
</html>