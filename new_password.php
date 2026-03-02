<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe - Le Monde</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Le Monde</h1>
        <p>Agrégateur de flux</p>
    </header>
    <main>
        <div class="card">
            <h2>Nouveau mot de passe</h2>
            <p class="subtitle">Choisissez un nouveau mot de passe pour votre compte</p>
            <?php
            // Récupérer le token depuis l'URL
            $token = $_GET['token'] ?? '';
            if (empty($token)) {
                die("Token manquant ou invalide.");
            }
            ?>
            <form action="assets/functions/traitement_new_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn">Réinitialiser</button>
            </form>
            <p class="link-text"><a href="connexion.php">Retour à la connexion</a></p>
        </div>
    </main>
</body>
</html>