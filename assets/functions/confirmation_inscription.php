<?php
$getToken = $_GET['token'];
if (empty($getToken)) {
    die("Token manquant.");
}

$fichier_users = '../../data/users.csv';
$lignes = array_map('str_getcsv', file($fichier_users));

$trouve = false;

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[4] === $getToken) {
        // Mettre à jour le champ "confirmé" (index 5) à 1
        $lignes[$index][5] = 1;
        $trouve = true;
        break;
    }
}



if ($trouve === true) {
    // Réécrire le fichier CSV avec les données mises à jour
    $infos = fopen($fichier_users, 'w');
    foreach ($lignes as $ligne) {
        fputcsv($infos, $ligne);
    }
    fclose($infos);
    header("Location: ../../confirmation_activation.php");
    exit();
} else {
    die("Token invalide ou expiré.");
}
