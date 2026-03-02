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

// on parcourt les utilisateurs pour trouver l'ID de l'utilisateur connecté
foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[2] === $email) {
        $id = $ligne[0];
        break;
    }
}

$fichier_abonnements = 'data/abonnements.csv';
$lignes_abonnements = array_map('str_getcsv', file($fichier_abonnements));
$thematiques = [];

// on parcourt les abonnements pour trouver ceux de l'utilisateur
foreach ($lignes_abonnements as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[0] == $id) {
        $thematiques[] = $ligne[1];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes flux RSS - Le Monde</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header style="padding-bottom: 0;">
        <h1>Le Monde</h1>
        <p>Agrégateur de flux</p>
        <nav class="nav-bar">
            <span class="user-name">Bonjour, <?php echo htmlspecialchars($_SESSION['nom']); ?></span>
            <a href="abonnements.php" class="nav-link">Gérer mes abonnements</a>
            <a href="assets/functions/deconnexion.php" class="nav-link logout">Déconnexion</a>
        </nav>
    </header>
    <main>
        <section id="flux">
            <div class="card">
                <h2>Mes flux RSS</h2>
                <?php if (empty($thematiques)): ?>
                    <p>Vous n'êtes abonné à aucune thématique. <a href="abonnements.php">Gérer mes abonnements</a></p>
                <?php else: ?>
                        <?php foreach ($thematiques as $thematique): ?>
                            <?php 
                            $url = "https://www.lemonde.fr/$thematique/rss_full.xml";
                            $xml = @simplexml_load_file($url);
                            if ($xml === false) continue;
                            ?>
                            <?php 
                            $count = 0;
                            foreach ($xml->channel->item as $item) {
                                if ($count >= 3) break; ?>
                                <div class="article">
                                    <span class="badge"><?php echo ucfirst(htmlspecialchars($thematique)); ?></span>
                                    <h3><?php echo htmlspecialchars((string)$item->title); ?></h3>
                                    <p class="description"><?php echo htmlspecialchars((string)$item->description); ?></p>
                                    <div class="article-footer">
                                        <p class="date"><?php echo date('d/m/Y à H:i', strtotime((string)$item->pubDate)); ?></p>
                                        <a href="<?php echo htmlspecialchars((string)$item->link); ?>" target="_blank">Lire l'article →</a>
                                    </div>
                                </div>
                                <?php
                                $count++;
                            }
                        ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>