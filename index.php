<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Le Monde</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Le Monde</h1>
        <p>Agrégateur de flux</p>
    </header>
    <main>
        <div class="card">
            <h2>Connexion</h2>
            <p class="subtitle">Accédez à votre espace personnel</p>
            <form action="assets/functions/traitement_connexion.php" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" required>
                </div>
                <?php
                // lit URL pour afficher les messages d'erreur
                if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
                    echo "<p style='color:red; text-align:center;'>Email ou mot de passe invalide, ou compte non confirmé.</p>";
                }
                ?>
                <button type="submit" class="btn">Se connecter</button>
            </form>
            <p class="link-text"><a href="reset_password.php">Mot de passe oublié ?</a></p>
            <p class="link-text">Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
        </div>
    </main>
</body>
</html>