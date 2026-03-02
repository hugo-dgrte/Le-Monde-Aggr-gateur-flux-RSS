<?php
session_start();
// Vérification de l'authentification
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

// récupère l'email depuis la session
$email = $_SESSION['email'];
$fichier_users = 'data/users.csv';
$lignes = array_map('str_getcsv', file($fichier_users));

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[2] === $email) {
        $id = $ligne[0];
        break;
    }
}

$fichier_abonnements = 'data/abonnements.csv';
$lignes_abonnements = array_map('str_getcsv', file($fichier_abonnements));
$abonnements_actuels = [];

foreach ($lignes_abonnements as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[0] == $id) {
        $abonnements_actuels[] = $ligne[1];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes abonnements - Le Monde</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header style="padding-bottom: 0;">
        <div class="header">
            <h1>Le Monde</h1>
            <p>Agrégateur de flux</p>
        </div>
        <nav class="nav-bar">
            <span class="user-name">Bonjour, <?php echo htmlspecialchars($_SESSION['nom']); ?></span>
            <a href="dashboard.php" class="nav-link">Mes flux RSS</a>
            <a href="assets/functions/deconnexion.php" class="nav-link logout">Déconnexion</a>
        </nav>
    </header>
    <main class="card">
        <h2>Gérer mes abonnements</h2>
        <p class="subtitle">Sélectionnez les catégories qui vous intéressent</p>
        <form action="assets/functions/traitement_abonnements.php" method="POST">
            <div class="subscriptions">
                <div class="subscription">
                    <input type="checkbox" id="politique" name="abonnements[]" value="politique" 
                        <?php echo in_array('politique', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="politique">
                        <strong>Politique</strong>
                        <span>Actualité politique française et débats parlementaires</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="economie" name="abonnements[]" value="economie" 
                        <?php echo in_array('economie', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="economie">
                        <strong>Économie</strong>
                        <span>Marchés financiers et analyse économique</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="culture" name="abonnements[]" value="culture" 
                        <?php echo in_array('culture', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="culture">
                        <strong>Culture</strong>
                        <span>Cinéma, théâtre, littérature et expositions</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="sport" name="abonnements[]" value="sport" 
                        <?php echo in_array('sport', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="sport">
                        <strong>Sport</strong>
                        <span>Résultats sportifs et compétitions</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="sciences" name="abonnements[]" value="sciences" 
                        <?php echo in_array('sciences', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="sciences">
                        <strong>Sciences</strong>
                        <span>Découvertes scientifiques et innovations</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="international" name="abonnements[]" value="international" 
                        <?php echo in_array('international', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="international">
                        <strong>International</strong>
                        <span>Actualité mondiale et relations internationales</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="education" name="abonnements[]" value="education" 
                        <?php echo in_array('education', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="education">
                        <strong>Éducation</strong>
                        <span>Système éducatif et pédagogie</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="planete" name="abonnements[]" value="planete" 
                        <?php echo in_array('planete', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="planete">
                        <strong>Planète</strong>
                        <span>Environnement et développement durable</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="pixels" name="abonnements[]" value="pixels" 
                        <?php echo in_array('pixels', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="pixels">
                        <strong>Pixels</strong>
                        <span>Jeux vidéo et culture numérique</span>
                    </label>
                </div>
                <div class="subscription">
                    <input type="checkbox" id="idees" name="abonnements[]" value="idees" 
                        <?php echo in_array('idees', $abonnements_actuels) ? 'checked' : ''; ?>>
                    <label for="idees">
                        <strong>Opinions</strong>
                        <span>Chroniques et tribunes</span>
                    </label>
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn">Enregistrer</button>
                <a href="dashboard.php" class="btn btn-secondary">Retour aux flux</a>
            </div>
        </form>
    </main>
</body>
</html>
