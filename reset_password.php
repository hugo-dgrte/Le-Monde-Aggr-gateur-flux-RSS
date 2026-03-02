<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - Le Monde</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Le Monde</h1>
        <p>Agrégateur de flux</p>
    </header>
    <main>
        <div class="container">
            <div class="card">
                <h2>Mot de passe oublié</h2>
                <p class="subtitle">Recevez un lien de réinitialisation par email</p>
                <form action="assets/functions/traitement_reset.php" method="POST">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <button type="submit" class="btn">Envoyer le lien</button>
                </form>
                <p class="link-text"><a href="index.php">Retour à la connexion</a></p>
            </div>
        </div>
    </main>
</body>
</html>